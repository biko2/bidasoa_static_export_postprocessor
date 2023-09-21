<?php

namespace Drupal\bidasoa_static_export_postprocessor;

use Drupal\static_export\Exporter\ExporterPluginInterface;

interface StaticExportPostprocessorInterface {

  public function postprocess(string $data, array $options) : string;

}
