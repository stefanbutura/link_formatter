<?php

/**
 * @file
 * Contains \Drupal\link_formatter\Plugin\Field\FieldFormatter\LinkFormatter
 */

namespace Drupal\link_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Plugin implementation of the 'link formatter'.
 *
 * @FieldFormatter(
 *   id = "link_formatter",
 *   label = @Translation("Link formatter"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class LinkFormatter extends FormatterBase
{

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $text = $item->uri;
      $result = $text;

      if ($this->isValidImage($result) == TRUE) {
        $element[$delta] = [
          '#theme' => 'link_formatter',
          '#url_type' => 'image',
          '#uri' => $result,
        ];
      }
      elseif ($this->isValidYoutube($result) == TRUE) {
        $element[$delta] = [
          '#theme' => 'link_formatter',
          '#url_type' => 'youtube',
          '#uri' => $result,
        ];
      }
      else {
        $element[$delta] = [
          '#type' => 'markup',
          '#markup' => 'Not a valid url',
        ];
      }
    }
    return $element;
  }

  /**
   * Tests whether the path is a valid image url.
   *
   * @param string $file
   *   An URL.
   *
   * @return bool
   *   Self explanatory
   */
  public function isValidImage($file) {
    if (preg_match('/(\.jpg|\.png|\.bmp)$/', $file)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Tests whether the path is a valid image url.
   *
   * @param string $file
   *   An URL.
   *
   * @return bool
   *   Self explanatory
   */
  public function isValidYoutube($file) {
    if (strpos($file, 'youtube.com') !== FALSE) {
      return TRUE;
    }
    return FALSE;
  }

}
