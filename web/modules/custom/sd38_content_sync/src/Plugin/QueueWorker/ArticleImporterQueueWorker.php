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
 *   id = "article_importer_queue_worker",
 *   title = @Translation("Article Import Queue Worker"),
 *   cron = {"time" = 60}
 * )
 */
class ArticleImporterQueueWorker extends BaseImporterQueueWorker {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    dpm('the item is processed');
  }

}
