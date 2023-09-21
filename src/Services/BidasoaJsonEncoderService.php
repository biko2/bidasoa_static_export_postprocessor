<?php

namespace Drupal\bidasoa_static_export_postprocessor\Services;

use Drupal\Core\Config\ConfigFactoryInterface;

class BidasoaJsonEncoderService {
  /**
   * Drupal config.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  public function __construct(
    ConfigFactoryInterface $configFactory
  ) {
    $this->configFactory = $configFactory;
  }
  public function encode(array $data) : string{
    $flagArray = [
      JSON_THROW_ON_ERROR,
      JSON_UNESCAPED_UNICODE,
      JSON_UNESCAPED_SLASHES,
    ];
    if ($this->configFactory->get('static_export_output_formatter_json.settings')
      ->get('pretty_print')) {
      $flagArray[] = JSON_PRETTY_PRINT;
    }
    $flags = array_reduce($flagArray, function ($a, $b) {
      return $a | $b;
    }, 0);
    return json_encode($data, $flags);
  }
}
