<?php

namespace Drupal\sd38_content_sync\Plugin\QueueWorker;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\file\FileInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \GuzzleHttp\ClientInterface;
use \Drupal\file\FileRepositoryInterface;

/**
 * Processes Importing Queue.
 *
 * @QueueWorker(
 *   id = "article_importer_queue_worker",
 *   title = @Translation("Article Import Queue Worker"),
 *   cron = {"time" = 60}
 * )
 */
class ArticleImporterQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  const API_QUERY_PARAMETERS = [
    'article' => '?include=field_attachments.field_media_file,field_image,field_carousel_image,field_embedded_articles,field_image_gallery,field_page_assignment,field_tags&fields[file--file,media--file]=uri,url',
    'page' => '?include=field_image,field_content_section,field_image_gallery,field_page_thumbnail_image&fields[file--file,media--file]=uri,url',
    'news_alert' => '?include=',
  ];

  /**
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  public $entityTypeManager;

  /**
   * @var \GuzzleHttp\ClientInterface
   */
  public $httpClient;

  /**
   * @var \Drupal\file\FileRepositoryInterface
   */
  public $fileRepository;

  /**
   * @var \Drupal\Core\File\FileSystemInterface
   */
  public $fileSystem;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   *
   * The Config Factory.
   *
   */
  protected $configFactory;

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $nodeStorage;

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $mediaStorage;

  /**
   * Constructs a ArticleImporterQueueWorker object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The Entity Type Manager.
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The HTTP Client service.
   * @param \Drupal\file\FileRepositoryInterface $fileRepository
   *   File repository.
   * @param FileSystemInterface $fileSystem
   *   File System service.
   * @param ConfigFactoryInterface $configFactory
   *    Config Factory.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entityTypeManager,
    ClientInterface $httpClient,
    FileRepositoryInterface $fileRepository,
    FileSystemInterface $fileSystem,
    ConfigFactoryInterface $configFactory
  ) {
    $this->configuration = $configuration;
    $this->pluginId = $plugin_id;
    $this->pluginDefinition = $plugin_definition;
    $this->entityTypeManager = $entityTypeManager;
    $this->httpClient = $httpClient;
    $this->fileRepository = $fileRepository;
    $this->fileSystem = $fileSystem;
    $this->configFactory = $configFactory;

    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
    $this->mediaStorage = $this->entityTypeManager->getStorage('media');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('http_client'),
      $container->get('file.repository'),
      $container->get('file_system'),
      $container->get('config.factory')
    );
  }


  public function getNode($apiUrl) {
    $client = \Drupal::httpClient();
    try {
      $response = $client->get($apiUrl, ['verify' => FALSE]);
      $data = json_decode($response->getBody()->getContents(), TRUE);
      $files = [];
      if (array_key_exists('included', $data)) {
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
    $config = $this->configFactory->get('sd38_content_sync.settings');
    $districtUrl = $config->get('d38_district_url') ?? '';

    $api = $districtUrl . '/jsonapi/node/' . $data['bundle'] . self::API_QUERY_PARAMETERS[$data['bundle']];
    $item = $this->getNode($api . '&filter[nid]=' . $data['nid']);

    [$jsonapi, $files] = $item;

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
        $preparedData['field_content_link'] = !empty($attributes['field_content_link']) ? $attributes['field_content_link']['url'] : '';
        break;
    }

    return $preparedData;
  }

  /**
   * Downloads an image from a URL and saves it as a managed file.
   *
   * @param string $url
   *   The image URL.
   *
   * @return \Drupal\file\Entity\File|false
   *   The file entity if the image was downloaded and saved successfully,
   *   or FALSE otherwise.
   */
  protected function downloadFile($url, $uri) {
    try {
      $config = $this->configFactory->get('sd38_content_sync.settings');
      $districtUrl = $config->get('d38_district_url') ?? '';

      // Download the image from the URL.
      $response = $this->httpClient->get($districtUrl . $url, ['stream' => TRUE, 'verify' => FALSE]);
      $image_data = $response->getBody()->getContents();

      $dir = dirname($uri);

      // Prepare the directory using the file_system service (Create directory if it doesn't exist).
      $this->fileSystem->prepareDirectory($dir, FileSystemInterface::CREATE_DIRECTORY);

      // Save the image data using the file_system service.
      $file_uri = $this->fileRepository->writeData($image_data, $uri, FileSystemInterface::EXISTS_REPLACE);

      return $file_uri;
    }
    catch (RequestException $e) {
      \Drupal::logger('sd38_content_sync')
        ->error('Failed to download file from URL: @url. Error: @error', [
          '@url' => $url,
          '@error' => $e->getMessage(),
        ]);
    }

    return FALSE;
  }

  protected function preprocessFile($url, $uri) {
    $file = $this->downloadFile($url, $uri);
    return [
      'target_id' => $file->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($rawJsonApidata) {

    $data = $this->retrieveData($rawJsonApidata);

    // Search for an existing node by an ID from district site.
    $query = $this->nodeStorage->getQuery()
      ->accessCheck(FALSE)
      ->condition('field_district_id', $data['field_district_id']);
    $nids = $query->execute();

    if (!empty($nids)) {
      // Load the existing node and update it.
      $nid = reset($nids);
      $node = $this->nodeStorage->load($nid);
    }
    else {
      // Create a new node.
      $node = $this->nodeStorage->create([
        'type' => $data['bundle'],
        'title' => $data['title'],
      ]);
      $node->set('field_district_id', $data['field_district_id']);
      $node->enforceIsNew();
    }

    $node->set('title', $data['title']);
    $node->set('status', 1);
    $node->set('uid', 1);

    $createdDateTime = new DrupalDateTime($data['created'], new \DateTimeZone('UTC'));
    $changedDateTime = new DrupalDateTime($data['changed'], new \DateTimeZone('UTC'));

    $node->set('created', $createdDateTime->getTimestamp());
    $node->set('changed', $changedDateTime->getTimestamp());
    $node->set('path', $data['path']);

    switch($data['bundle']) {
      case 'page':
        if (!empty($data['body'])){
          $node->set('body', [
            'value' => $data['body'],
            'format' => 'full_html',
          ]);
        }

        if (!empty($data['field_feature_image']) && !empty($data['field_feature_image']['url']['url'])) {
          $file = $this->downloadFile($data['field_feature_image']['url']['url'], $data['field_feature_image']['url']['uri']);
          // Create the media entity.
          $media = $this->mediaStorage->create([
            'bundle' => 'image',
            'name' =>  $file->getFilename(),
            'uid' => 1,
            'status' => 1,
            'field_media_image' => [
              'target_id' => $file->id(),
            ],
          ]);
          $media->save();

          $field_feature_image = [
            'target_id' => $media->id(),
          ];
          $node->set('field_feature_image', $field_feature_image);
        }

        if (!empty($data['field_page_thumbnail_image'])) {
          $field_feature_image = $this->preprocessFile($data['field_page_thumbnail_image']['url']['url'], $data['field_page_thumbnail_image']['url']['uri']);
          $node->set('field_page_thumbnail_image', $field_feature_image);
        }

        break;
      case 'news_alert':
        $node->set('field_alert_title', $data['title']);
        $node->set('field_alert_type', $data['field_alert_type']);
        $node->set('field_alert_redirect', $data['field_content_link']);

        $node->set('body', [
          'value' => $data['field_news_alert_description'],
          'summary' => $data['field_news_alert_description'],
          'format' => 'full_html',
        ]);

        break;
      case 'article':

        if (!empty($data['body'])){
          $node->set('body', [
            'value' => $data['body'],
            'format' => 'full_html',
          ]);
        }

        if (!empty($data['field_attachments'])) {
          $attachments = [];
          foreach ($data['field_attachments'] as $incomingAttachment) {
            /** @var FileInterface $file */
            $file = $this->downloadFile($incomingAttachment['url']['url'], $incomingAttachment['url']['uri']);

            // Create the media entity.
            $media = $this->mediaStorage->create([
              'bundle' => 'file',
              'name' =>  $file->getFilename(),
              'uid' => 1,
              'status' => 1,
              'field_media_file' => [
                'target_id' => $file->id(),
              ],
            ]);
            $media->save();

            $attachments[] =  [
              'target_id' => $media->id(),
            ];
          }
          $node->set('field_attachments', $attachments);
        }
        if (!empty($data['field_feature_image']) && !empty($data['field_feature_image']['url']['url'])) {
          $file = $this->downloadFile($data['field_feature_image']['url']['url'], $data['field_feature_image']['url']['uri']);

          // Create the media entity.
          $media = $this->mediaStorage->create([
            'bundle' => 'image',
            'name' =>  $file->getFilename(),
            'uid' => 1,
            'status' => 1,
            'field_media_image' => [
              'target_id' => $file->id(),
            ],
          ]);
          $media->save();

          $field_feature_image = [
            'target_id' => $media->id(),
          ];
          $node->set('field_feature_image', $field_feature_image);
        }
        break;
    }

    $node->save();
  }
}
