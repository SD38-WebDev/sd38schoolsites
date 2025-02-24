<?php

namespace Drupal\sd38_content_sync\Plugin\QueueWorker;

use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\taxonomy\Entity\Term;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Drupal\Core\File\FileSystemInterface;


abstract class BaseImporterQueueWorker extends QueueWorkerBase {


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

  protected function downloadImage($url) {
    $client = \Drupal::httpClient();
    $file_system = \Drupal::service('file_system'); // Get the file_system service
    $file_repository = \Drupal::service('file.repository'); // Get the file_system service

    try {
      // Download the image from the URL.
      $response = $client->get($url, ['stream' => TRUE]);
      $image_data = $response->getBody()->getContents();

      // Extract the image file name from the URL.
      $file_name = basename($url);

      // Set the file path in the public file system.
      $file_path = 'public://product/' . $file_name . '.webp';
      $dir = 'public://product';
      // Prepare the directory using the file_system service (Create directory if it doesn't exist).
      $file_system->prepareDirectory($dir, FileSystemInterface::CREATE_DIRECTORY);

      // Save the image data using the file_system service.
      $file_uri = $file_repository->writeData($image_data, $file_path, FileSystemInterface::EXISTS_REPLACE);
      return $file_uri;
    }
    catch (RequestException $e) {
      \Drupal::logger('product_import')
        ->error('Failed to download image from URL: @url. Error: @error', [
          '@url' => $url,
          '@error' => $e->getMessage(),
        ]);
    }

    return FALSE;
  }

}
