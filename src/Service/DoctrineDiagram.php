<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramBundle\Constants\Converter;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlToImage\PlantUml;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use function file_put_contents;
use function is_string;

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
    private string             $converter,
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
    $this->toolbox->isValidFormat($format) or throw new RuntimeException("Invalid format {$format}.");

    return match ($converter) {
      Converter::JAR    => $this->convertWithJar($puml, $format, $jar),
      Converter::SERVER => $this->convertWithServer($puml, $format, $server),
      Converter::AUTO   => $this->convertAuto($puml, $format, $server, $jar),
      default           => throw new RuntimeException('Invalid converter')
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

  /**
   * Dump image into a file.
   *
   * @param string      $content  The diagram content to be dumped.
   * @param string|null $filename Target file name. This can be a path, {@see Filesystem} is able to handle it.
   * @param string|null $format   Target file extension.
   */
  public function dumpDiagram(string $content, ?string $filename, ?string $format): string
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
