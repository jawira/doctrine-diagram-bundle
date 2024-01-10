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

  public function __construct(
    public ConnectionRegistry $doctrine,
    private string $size,
    private string $filename,
    private string $extension,
    private string $server,
    private string $connection,
  )
  {
  }

  public function generatePuml(string $connectionName, string $size): string
  {
    $connection = $this->doctrine->getConnection($connectionName);
    /** @var \Doctrine\DBAL\Connection $connection */
    $dbDraw = new DbDraw($connection);

    return $dbDraw->generatePuml($size);
  }

  public function convertWithServer(string $puml, string $format, string $server = Client::SERVER): string
  {
    throw_unless(in_array($format, [self::PUML,
      Format::SVG,
      Format::PNG]), new RuntimeException("Invalid format $format"));
    if ($format === self::PUML) {
      return $puml;
    }

    return (new Client($server))->generateImage($puml, $format);
  }

  public function dumpDiagram(string $filename, string $content): void
  {
    (new Filesystem)->dumpFile($filename, $content);
  }
}
