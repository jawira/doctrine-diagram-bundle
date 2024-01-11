<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use Jawira\PlantUmlClient\Client;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use function in_array;
use function Jawira\TheLostFunctions\throw_unless;
use function str_ends_with;

class DoctrineDiagram
{

  public function __construct(
    private ConnectionRegistry $doctrine,
    /** This value comes from doctrine_diagram.yaml */
    private string             $size,
    /** This value comes from doctrine_diagram.yaml */
    private string             $filename,
    /** This value comes from doctrine_diagram.yaml */
    private string             $format,
    /** This value comes from doctrine_diagram.yaml */
    private string             $server,
    /** This value comes from doctrine_diagram.yaml */
    private string             $connection,
  )
  {
  }

  /**
   * Generate a Puml diagram using a Doctrine connection.
   */
  public function generatePuml(?string $connectionName = null, ?string $size = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $connectionName ??= $this->connection;
    $size           ??= $this->size;

    // Generate puml diagram
    $connection = $this->doctrine->getConnection($connectionName);
    /** @var \Doctrine\DBAL\Connection $connection */
    $dbDraw = new DbDraw($connection);

    return $dbDraw->generatePuml($size);
  }

  /**
   * Convert diagram from Puml to another format using remote PlantUML server.
   *
   * @param string $puml Diagram in puml format.
   * @param string|null $format Convert puml diagram to this format.
   * @param string|null $server PlantUML server to use to do conversion.
   * @return string
   */
  public function convertWithServer(string $puml, ?string $format = null, ?string $server = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $format ??= $this->format;
    $server ??= $this->server;


    throw_unless(
      in_array($format, [Format::PUML, Format::SVG, Format::PNG]),
      new RuntimeException("Invalid format $format")
    );

    if ($format === Format::PUML) {
      return $puml;
    }

    return (new Client($server))->generateImage($puml, $format);
  }

  /**
   * Dump image into a file.
   *
   * @param string $content The diagram content to be dumped.
   * @param string|null $filename Target file name.
   * @param string|null $format Target file extension.
   * @return string
   */
  public function dumpDiagram(string $content, ?string $filename = null, ?string $format = null): string
  {
    // Fallback values from doctrine_diagram.yaml
    $filename ??= $this->filename;
    $format   ??= $this->format;

    $fullName = str_ends_with($filename, ".$format") ? $filename : "$filename.$format";
    (new Filesystem)->dumpFile($fullName, $content);

    return $fullName;
  }
}
