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

/**
 * Processes Importing Queue.
 *
 * @QueueWorker(
 *   id = "preprocess_importer_queue_worker",
 *   title = @Translation("Preprocess Import Queue Worker"),
 *   cron = {"time" = 60}
 * )
 */
class PreprocessImporterQueueWorker extends BaseImporterQueueWorker {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $nodeRaw = [
      'title' => $data[2],

    ];
  }

}
