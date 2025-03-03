<?php

namespace Drupal\sd38_content_sync\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGenerator;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\Queue\QueueWorkerInterface;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
use Drupal\node\Entity\Node;
use Drupal\sd38_content_sync\ImporterPreprocessManager;
use Drupal\taxonomy\Entity\Term;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Processes Importing Queue.
 *
 * @QueueWorker(
 *   id = "preprocess_importer_queue_worker",
 *   title = @Translation("Preprocess Import Queue Worker"),
 *   cron = {"time" = 60}
 * )
 */
class PreprocessImporterQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {


  const API_QUERY_PARAMETERS = [
    'article' => '?include=field_attachments.field_media_file,field_image,field_carousel_image,field_embedded_articles,field_image_gallery,field_page_assignment,field_tags&fields[file--file,media--file]=uri,url',
    'page' => '?include=field_image,field_content_section,field_image_gallery,field_page_thumbnail_image&fields[file--file,media--file]=uri,url',
    'news_alert' => '?include=',
  ];

  const DISTRICT_URL = 'http://sd38districtwebsite.docksal.site';


  protected $em;

  protected $preprocessManager;

  /**
   * Creates a new NodePublishBase object.
   */
  public function __construct(
    EntityTypeManagerInterface $em,
    ImporterPreprocessManager $preprocess_manager
  ) {
    $this->em = $em;
    $this->preprocessManager = $preprocess_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('sd38_content_sync.preprocess_manager')
    );
  }

  public function getNode($apiUrl) {
    $client = \Drupal::httpClient();
    try {
      $response = $client->get($apiUrl);
      $data = json_decode($response->getBody()->getContents(), TRUE);
      $files = [];
      $attachments = $data['included'];
      foreach ($attachments as $attachment) {
        if ($attachment['type'] == "file--file") {
          $files[$attachment['id']] = empty($attachment['attributes']['uri']) ? NULL : [ 'url' => $attachment['attributes']['uri']['url'], 'uri' => $attachment['attributes']['uri']['value']];
        }
        elseif ($attachment['type'] == "media--file") {
          $fileId = $attachment['relationships']['field_media_file']['data']['id'];

          $fileDetails = array_filter($attachments, function($item) use ($fileId) {
            return $item['id'] == $fileId;
          });
          $fileDetailsItem = reset($fileDetails);
          $files[$attachment['id']] =  ['url' => $fileDetailsItem['attributes']['uri']['url'], 'uri' => $fileDetailsItem['attributes']['uri']['value']];
        }
      }
      return [$data, $files];
    }
    catch (RequestException $e) {
      \Drupal::logger('sd38_content_sync')
        ->error('Failed to fetch data for sd38_news code: @code. Error: @error', [
          '@code' => '',
          '@error' => $e->getMessage(),
        ]);
      return NULL;
    }
  }


  public function retrieveData($data) {

    $preparedData = [];
    $api = self::DISTRICT_URL . '/jsonapi/node/' . $data['bundle'] . self::API_QUERY_PARAMETERS[$data['bundle']];
    $item = $this->getNode($api . '&filter[nid]=' . $data['nid']);
    list($jsonapi, $files) = $item;
    $item = $jsonapi['data'][0];

    $attributes = $item['attributes'];
    $preparedData = [
      'title' => $attributes['title'],
      'created' => $attributes['created'],
      'changed' => $attributes['changed'],
      'path' => $attributes['path']['alias'],
      'body' => $attributes['body']['value'],
      'bundle' => $data['bundle'],
      'field_district_id' => $data['nid']
    ];

    switch ($data['bundle']) {

      case 'article':
        if (!empty($jsonapi['data'][0]['relationships']['field_attachments']['data'])) {
          $preparedData['field_attachments'] = array_map(function($item) use ($files) {
            $item['url'] = $files[$item['id']];
            return $item;
          }, $jsonapi['data'][0]['relationships']['field_attachments']['data']);
        }
        $preparedData['field_feature_image'] = ['url' =>  $files[$jsonapi['data'][0]['relationships']['field_image']['data']['id']]];
        break;

      case 'page':
        $preparedData['field_body_2'] = $attributes['field_body_2']['value'];
        $preparedData['field_feature_page'] = $attributes['field_feature_page'];
        if (!empty($jsonapi['data'][0]['relationships']['field_image_gallery']['data'])) {
          $preparedData['field_image_gallery'] = array_map(function($item) use ($files) {
            $item['url'] = $files[$item['id']];
            return $item;
          }, $jsonapi['data'][0]['relationships']['field_image_gallery']['data']);
        }
        $preparedData['field_feature_image'] = ['url' =>  $files[$jsonapi['data'][0]['relationships']['field_image']['data']['id']]];
        if (!empty($jsonapi['data'][0]['relationships']['field_page_thumbnail_image']['data'])) {
          $preparedData['field_page_thumbnail_image'] = ['url' =>  $files[$jsonapi['data'][0]['relationships']['field_page_thumbnail_image']['data']['id']]];
        }
        break;

      case 'news_alert':
        $preparedData['field_alert_type'] = $attributes['field_alert_type'];
        $preparedData['field_news_alert_description'] = $attributes['field_news_alert_description'];
        $preparedData['field_content_link'] = $attributes['field_content_link'];
        break;
    }

    return $preparedData;
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $preprocessedData = $this->retrieveData($data);
    $queue = \Drupal::service('queue')->get('article_importer_queue_worker');
    $queue->createItem($preprocessedData);
  }
}
