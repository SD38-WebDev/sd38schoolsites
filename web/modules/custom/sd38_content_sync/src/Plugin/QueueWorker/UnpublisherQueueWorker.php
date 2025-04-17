<?php

namespace Drupal\sd38_content_sync\Plugin\QueueWorker;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\file\FileInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \GuzzleHttp\ClientInterface;
use \Drupal\file\FileRepositoryInterface;

/**
 * Processes Unpublisher Queue.
 *
 * @QueueWorker(
 *   id = "unpublisher_queue_worker",
 *   title = @Translation("Unpublisher Queue Worker"),
 *   cron = {"time" = 60}
 * )
 */
class UnpublisherQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

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
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $paragraphStorage;

  protected $jsonApi;
  protected $files;

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
    $this->paragraphStorage = $this->entityTypeManager->getStorage('paragraph');
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

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {

    // Search for an existing node by an ID from district site.
    $query = $this->nodeStorage->getQuery()
      ->accessCheck(FALSE)
      ->condition('field_district_id', $data['nid']);
    $nids = $query->execute();

    if (!empty($nids)) {
      // Load the existing node and update it.
      $nid = reset($nids);
      $node = $this->nodeStorage->load($nid);
      $node->delete();
    }
  }
}
