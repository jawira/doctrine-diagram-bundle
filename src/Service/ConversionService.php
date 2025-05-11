<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Jawira\DoctrineDiagramBundle\Constants\Converter;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlToImage\PlantUml;

/**
 * Convert PUML diagram to another format when required.
 */
class ConversionService
{
  public function __construct(
    private readonly PlantUml $pumlToImage,
    private readonly Toolbox  $toolbox,
    private readonly string   $format,
    private readonly ?string  $jar,
    private readonly string   $server,
    private readonly string   $converter,
  ) {
  }

  public function convert(string $puml, ?string $format, ?string $converter, ?string $server, ?string $jar): string
  {
    // Fallback values from doctrine_diagram.yaml
    $format    ??= $this->format;
    $converter ??= $this->converter;
    $server    ??= $this->server;
    $jar       ??= $this->jar;

    if ($format === Format::PUML) {
      return $puml;
    }
    $this->toolbox->isValidFormat($format) or throw new \RuntimeException("Invalid format {$format}.");

    return match ($converter) {
      Converter::JAR    => $this->convertWithJar($puml, $format, $jar),
      Converter::SERVER => $this->convertWithServer($puml, $format, $server),
      Converter::AUTO   => $this->convertAuto($puml, $format, $server, $jar),
      default           => throw new \RuntimeException('Invalid converter')
    };
  }

  /**
   * Convert diagram with jar file if it's available, or use server otherwise.
   */
  private function convertAuto(string $puml, string $format, string $server, ?string $jar): string
  {
    if (is_string($jar)) {
      $this->pumlToImage->setJar($jar);
    }
    if ($this->pumlToImage->isPlantUmlAvailable()) {
      return $this->convertWithJar($puml, $format, $jar);
    }

    return $this->convertWithServer($puml, $format, $server);
  }

  /**
   * Converts PlantUml diagram using jar file or executable as fallback.
   *
   * @param string|null $jar When `null` {@see DoctrineDiagram} will try to find Jar.
   */
  private function convertWithJar(string $puml, string $format, ?string $jar): string
  {
    if (is_string($jar)) {
      $this->pumlToImage->setJar($jar);
    }
    return $this->pumlToImage->convertTo($puml, $format);
  }

  /**
   * Convert diagram from Puml to another format using remote PlantUML server.
   *
   * @param string $puml   Diagram in puml format.
   * @param string $format Convert puml diagram to this format.
   * @param string $server PlantUML server to use to do conversion.
   */
  private function convertWithServer(string $puml, string $format, string $server): string
  {
    return (new Client($server))->generateImage($puml, $format);
  }
}
