<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlClient\Format;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use function in_array;
use function Jawira\TheLostFunctions\throw_unless;

class DoctrineDiagram
{
  const PUML = 'puml';

  public ConnectionRegistry $doctrine;

  public function __construct(ConnectionRegistry $doctrine)
  {
    $this->doctrine = $doctrine;
  }

  public function generatePuml(string $connectionName, string $size)
  {
    $connection = $this->doctrine->getConnection($connectionName);
    /** @var \Doctrine\DBAL\Connection $connection */
    $dbDraw = new DbDraw($connection);

    return $dbDraw->generatePuml($size);
  }

  public function convertWithServer(string $puml, string $format)
  {
    throw_unless(in_array($format, [self::PUML,
                                    Format::SVG,
                                    Format::PNG]), new RuntimeException("Invalid format $format"));
    if ($format === self::PUML) {
      return $puml;
    }

    return (new Client)->generateImage($puml, $format);
  }

  public function dumpDiagram(string $filename, string $content)
  {
    (new Filesystem)->dumpFile($filename, $content);
  }
}
