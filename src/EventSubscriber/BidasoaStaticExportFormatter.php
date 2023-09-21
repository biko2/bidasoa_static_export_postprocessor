<?php

namespace Drupal\bidasoa_static_export_postprocessor\EventSubscriber;


use Drupal\bidasoa_static_export_postprocessor\Services\PostprocessorService;
use Drupal\static_export\Event\StaticExportEvent;
use Drupal\static_export\Event\StaticExportEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BidasoaStaticExportFormatter implements EventSubscriberInterface {

  /**
   * Formatter Service.
   *
   * @var \Drupal\bidasoa_static_export_postprocessor\Services\PostprocessorService
   */
  protected $postProcessorService;

  /**
   * StaticExportEventSubscriber constructor.
   *
   * @param \Drupal\bidasoa_static_export_postprocessor\Services\PostprocessorService $postProcessorService
   *   Formatter Service.
   */
  public function __construct(PostprocessorService $postProcessorService) {
    $this->postProcessorService = $postProcessorService;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
      $events[StaticExportEvents::FORMATTER_END][] = ['onFormatterEnds'];
      return $events;
  }

  /**
   * Reacts to a StaticExportEvents::FORMATTER_ENDS event.
   *
   * @param \Drupal\static_export\Event\StaticExportEvent $event
   *   The static export event.
   *
   * @return \Drupal\static_export\Event\StaticExportEvent
   *   The processed event.
   */
  public function onFormatterEnds(StaticExportEvent $event): StaticExportEvent {
    $exporter = $event->getExporter();
    $dataFromFormatter = $event->getDataFromFormatter();
    $options = ['exporterId' => $exporter->getBaseId()];
    $formattedData = $this->postProcessorService->postprocess($dataFromFormatter,$options);
    $event->setDataFromFormatter($formattedData);

    return $event;
  }


}
