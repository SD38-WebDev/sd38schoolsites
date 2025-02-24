<?php

namespace Drupal\sd38_content_sync;

use Drupal\Core\Queue\QueueFactory;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImporterPreprocessManager {

  public function getNode($apiUrl, $nid) {

    $client = \Drupal::httpClient();
    try {
      $response = $client->get($apiUrl);
      $data = json_decode($response->getBody()->getContents(), TRUE);

      $files = [];

      $attachments = $data['included'];

      foreach ($attachments as $attachment) {
        $files[$attachment['id']] = empty($attachment['attributes']['uri']) ? NULL : $attachment['attributes']['uri']['url'];
      }

      return [$data, $files];

    }
    catch (RequestException $e) {
      \Drupal::logger('sd38_news')
        ->error('Failed to fetch data for sd38_news code: @code. Error: @error', [
          '@code' => '',
          '@error' => $e->getMessage(),
        ]);
      return NULL;
    }
  }

  public function retrieveData($data) {

    switch ($data['bundle']) {
      case 'news':
        $api = 'https://sd38.bc.ca/jsonapi/node/article?include=field_attachments,field_image&fields[file--file]=uri,url&page[limit]=3';
        $item = $this->getNode($api. $data['nid']);
        list($jsonapi, $files) = $item;
        $item = $jsonapi['data'];
        $preparedArticle = [
          'data' => [
            'nid' => $item['attributes']['drupal_internal__nid'],
            'title' => $item['attributes']['drupal_internal__nid'],
            'created' => $item['attributes']['created'],
            'changed' => $item['attributes']['changed'],
            'path' => $item['attributes']['path']['alias'],
            'publish_on' => $item['attributes']['publish_on'],
            'unpublish_on' => $item['attributes']['unpublish_on'],
            'body' => $item['attributes']['body']['value'],
            'field_attachments' => array_map(function(&$item) use ($files) {
              $item['url'] = $files[$item['id']];
            }, $item['relationships']['field_attachments']['data']),
            'field_feature_image' => [
              'url' => $files[$item['relationships']['field_image']['data']['id']]
            ],
            'field_tags' => $item['relationships']['field_tags']['data'],
          ],
        ];
        break;
    }

      }
}
