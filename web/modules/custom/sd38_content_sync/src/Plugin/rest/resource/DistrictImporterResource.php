<?php

namespace Drupal\sd38_content_sync\Plugin\rest\resource;

use Drupal\Core\State\StateInterface;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\rest\ResourceResponse;

/**
 * Provides a REST resource for handling import requests.
 *
 * @RestResource(
 *   id = "district_importer",
 *   label = @Translation("District Importer"),
 *   uri_paths = {
 *     "create" = "/api/district-import"
 *   }
 * )
 */
class DistrictImporterResource extends ResourceBase {

  /**
   * State service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\State\StateInterface $state
   *   A current user instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, array $serializer_formats, LoggerInterface $logger,  StateInterface $state) {

    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('district_importer'),
      $container->get('state')
    );
  }

  /**
   * Responds to POST requests.
   *
   * @param mixed $data
   *   Data to create the node.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function post(Request $request) {

    $data = json_decode($request->getContent(), TRUE);

    if (!$data) {
      return new ResourceResponse(['error' => 'Invalid JSON'], 400);
    }

    $queue = \Drupal::service('queue')->get('article_importer_queue_worker');

    $queue->createItem([
      'bundle' => $data['bundle'],
      'nid' => $data['nid']
    ]);

    return new ResourceResponse(['message' => 'Added to queue.'], 200);
  }
}
