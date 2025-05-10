<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;


use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use RuntimeException;

class ErDiagram
{
  public function __construct(
    private ConnectionRegistry $doctrine,
    private string             $size,
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
}
