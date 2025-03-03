<?php

namespace Drupal\sd38_content_sync;

use Drupal\Core\Queue\QueueFactory;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImporterPreprocessManager {

  /**
   * Paragraph fields mapping in format:
   * districtParagraphName => ['districtFieldName' => 'schoolFieldName'].
   *
   * @return array[]
   */
  function paragraphMapping() {
    return [
      'blog_feed' => [
        'field_section_title' => 'field_section_title',
        'field_section_content' => '',
        'field_referenced_tags' => 'field_referenced_tags',
      ],
      'basic_text_section' => [
        'field_bg' => 'field_add_background_colour',
        'field_bgcolour' => 'field_background_colour',
        'field_section_content' => 'field_section_content',
        'field_section_title' => 'field_section_title',
        //'paragraph_view_mode' => '',
        //'field_css_id' => '',
      ],
      'image_gallery' => [
        'paragraph_view_mode' => '',
        'field_images' => '',
        'field_section_content' => '',
        'field_section_title' => '',
      ]
    ];

  }

}
