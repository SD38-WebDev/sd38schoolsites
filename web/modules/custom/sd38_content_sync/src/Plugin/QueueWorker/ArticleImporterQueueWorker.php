<?php

namespace Drupal\sd38_content_sync\Plugin\QueueWorker;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Queue\QueueWorkerBase;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\File\FileSystemInterface;
use Drupal\media\Entity\Media;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

  /**
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  public $entityTypeManager;

  public $httpClient;

  public $fileRepository;

  public $fileSystem;


  /**
   * Constructs a \Drupal\Component\Plugin\PluginBase object.
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
   *   The HTTP Client service.
   * @param FileSystemInterface $fileSystem
   *   The HTTP Client service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $entityTypeManager,
  $httpClient, $fileRepository, $fileSystem) {
    $this->configuration = $configuration;
    $this->pluginId = $plugin_id;
    $this->pluginDefinition = $plugin_definition;
    $this->entityTypeManager = $entityTypeManager;
    $this->httpClient = $httpClient;
    $this->fileRepository = $fileRepository;
    $this->fileSystem = $fileSystem;
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
      $container->get('file_system')

    );
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
      // Download the image from the URL.
      $response = $this->httpClient->get('http://sd38districtwebsite.docksal.site'. $url, ['stream' => TRUE]);
      $image_data = $response->getBody()->getContents();

      $dir = 'public://2025-02';

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
  public function processItem($data) {
    $node = $this->entityTypeManager->getStorage('node')->create(["type" => $data['bundle']]);

    $node->set("title", $data['title']);
    $node->set("status", 1);
    $node->set("uid", 1);

    $createdDateTime = new DrupalDateTime($data['created'], new \DateTimeZone('UTC'));
    $changedDateTime = new DrupalDateTime($data['changed'], new \DateTimeZone('UTC'));

    $node->set("created", $createdDateTime->getTimestamp());
    $node->set("changed", $changedDateTime->getTimestamp());
    $node->set("path", $data['path']);

    switch($data['bundle']) {
      case 'page':
        if (!empty($data['body'])){
          $node->set("body", [
            'value' => $data['body'],
            'format' => 'full_html',
          ]);
        }

        // Accordion
        //Article Feed
        //Basic Text Section
        //Embedded Video
        //Image Gallery
        //Media and Text Section
        //Calendar Events (List)
        //Tile Links Section
        //File Attachments
        //Image Banner
        //Promo Cards Section

        //$node->set("field_feature_page", $data['field_feature_page']);

        if (!empty($data['field_feature_image'])) {
          $file = $this->downloadFile($data['field_feature_image']['url']['url'], $data['field_feature_image']['url']['uri']);

          // Create the media entity.
          $media = $this->entityTypeManager->getStorage('media')->create([
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

        /*if (!empty($data['field_image_gallery'])) {
          $images = [];
          foreach ($data['field_image_gallery'] as $incomingAttachment) {
            $images[] = $this->preprocessFile($incomingAttachment['url']['url'], $incomingAttachment['url']['uri']);
          }
          $node->set('field_image_gallery', $images);
        }*/

        break;
      case 'news_alert':
          //field_alert_redirect
          $node->set("field_alert_title", $data['title']);
          $node->set("field_alert_type", $data['field_alert_type']);
          $node->set("summary", $data['field_news_alert_description']);

        break;
      case 'article':

        if (!empty($data['body'])){
          $node->set("body", [
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
            $media = $this->entityTypeManager->getStorage('media')->create([
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
        if (!empty($data['field_feature_image'])) {
          $file = $this->downloadFile($data['field_feature_image']['url']['url'], $data['field_feature_image']['url']['uri']);

          // Create the media entity.
          $media = $this->entityTypeManager->getStorage('media')->create([
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


    $node->enforceIsNew();
    $node->save();
  }
}
