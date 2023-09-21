<?php

namespace Drupal\bidasoa_static_export_postprocessor\Services;

use Drupal\bidasoa_static_export_postprocessor\StaticExportPostprocessorInterface;
use Drupal\static_export\Exporter\ExporterPluginInterface;

class PostprocessorService {

    protected $postprocessors;
    protected $sortedPostprocessors;

    public function postprocess(string $data, array $options){
      if ($this->sortedPostprocessors === NULL) {
        $this->sortedPostprocessors = $this->sortPostprocessors();
      }
      foreach($this->sortedPostprocessors as $postprocessor){
        $data = $postprocessor->postprocess($data,$options);
      }
      return $data;
    }
    public function addPostprocessor(StaticExportPostprocessorInterface $postprocessor, $priority = 0) {
      $this->postprocessors[$priority][] = $postprocessor;
      // Reset sorted translators property to trigger rebuild.
      $this->sortedPostprocessors = NULL;
      return $this;
    }
    protected function sortPostprocessors() {
      $sorted = [];
      krsort($this->postprocessors);

      foreach ($this->postprocessors as $postprocessors) {
        $sorted = array_merge($sorted, $postprocessors);
      }
      return $sorted;
    }

}
