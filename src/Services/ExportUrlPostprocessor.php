<?php

namespace Drupal\bidasoa_static_export_postprocessor\Services;

use Drupal\bidasoa_static_export_postprocessor\StaticExportPostprocessorInterface;
use Drupal\Core\Site\Settings;
use Drupal\static_export\Exporter\ExporterPluginInterface;

class ExportUrlPostprocessor implements StaticExportPostprocessorInterface {
  public function postprocess(string $data, array $options) : string{
    $decodedData = json_decode($data, true);
    return $this->formatDomain(
      $data,
      Settings::get('bidasoa_cms_url'),
      Settings::get('bidasoa_front_url')
    );
  }
  private function formatDomain(string $data, string $domainBackend, string $domainFrontend){
    return str_replace($domainBackend, $domainFrontend, $data);
  }
}

