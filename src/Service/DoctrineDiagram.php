<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlToImage\PlantUml;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Main service to generate diagrams.
 */
class DoctrineDiagram
{
  public function __construct(
    private ConnectionRegistry $doctrine,
    private PlantUml           $pumlToImage,
    private Toolbox            $toolbox,
    private string             $size,
    private string             $filename,
    private string             $format,
    private ?string            $jar,
    private string             $server,
    private string             $theme,
    private ?string            $connection,
    /** @var string[] */
    private array              $exclude,
  ) {
  }

  /**
   * Generate a Puml diagram using a Doctrine connection.
   *
   * The arguments of this method come from the console. If no values are provided, then the values from the config
   * file are used as a fallback.
   *
   * @param null|string[] $exclude List of tables to exclude from diagram.
   */
  public function generatePuml(?string $connectionName = null, ?string $size = null, ?string $theme = null, ?array $exclude = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $connectionName ??= $this->connection;
    $size           ??= $this->size;
    $theme          ??= $this->theme;
    $exclude        ??= $this->exclude;

    // Generate puml diagram
    $connection = $this->doctrine->getConnection($connectionName);
    ($connection instanceof Connection) or throw new RuntimeException('Cannot get required Connection');
    $dbDraw = new DbDraw($connection);

    return $dbDraw->generatePuml($size, $theme, $exclude);
  }

  /**
   * Convert diagram with jar file if it's available, or use server otherwise.
   */
  public function convertAuto(string $puml, ?string $format = null, ?string $server = null, ?string $jar = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $jar ??= $this->jar;

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
   */
  public function convertWithJar(string $puml, ?string $format = null, ?string $jar = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $format ??= $this->format;
    $jar    ??= $this->jar;

    if (is_string($jar)) {
      $this->pumlToImage->setJar($jar);
    }
    return $this->pumlToImage->convertTo($puml, $format);
  }

  /**
   * Convert diagram from Puml to another format using remote PlantUML server.
   *
   * @param string      $puml   Diagram in puml format.
   * @param string|null $format Convert puml diagram to this format.
   * @param string|null $server PlantUML server to use to do conversion.
   * @return string
   */
  public function convertWithServer(string $puml, ?string $format = null, ?string $server = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $format ??= $this->format;
    $server ??= $this->server;

    $this->toolbox->isValidFormat($format) or throw new RuntimeException("Invalid format {$format}.");

    if ($format === Format::PUML) {
      return $puml;
    }

    return (new Client($server))->generateImage($puml, $format);
  }

  /**
   * Dump image into a file.
   *
   * @param string      $content  The diagram content to be dumped.
   * @param string|null $filename Target file name. This can be a path, {@see Filesystem} is able to handle it.
   * @param string|null $format   Target file extension.
   * @return string
   */
  public function dumpDiagram(string $content, ?string $filename = null, ?string $format = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $filename ??= $this->filename;
    $format   ??= $this->format;

    if (!$this->toolbox->isWrapper($filename)) {
      $filename = $this->toolbox->appendExtension($filename, $format);
    }
    file_put_contents($filename, $content);

    return $filename;
  }
}
