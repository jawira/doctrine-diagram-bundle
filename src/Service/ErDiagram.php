<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;


use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramContracts\Size;
use RuntimeException;

class ErDiagram
{
  public function __construct(
    private readonly ManagerRegistry $doctrine,
    private readonly string          $size,
    private readonly string          $theme,
    private readonly ?string         $connection,
    /** @var string[] */
    private readonly array           $include,
    /** @var string[] */
    private readonly array           $exclude,
  ) {
  }


  /**
   * Generate a Puml diagram using a Doctrine connection.
   *
   * The arguments of this method come from the console. If no values are provided, then the values from the config
   * file are used as a fallback.
   *
   * @param null|string[] $include List of tables to add to the diagram.
   * @param null|string[] $exclude List of tables to remove from the diagram.
   */
  public function generatePuml(?string $connectionName, ?string $size, ?string $theme, ?array $include, ?array $exclude): string
  {
    // Fallback values from doctrine_diagram.yaml
    $connectionName ??= $this->connection;
    $size           ??= $this->size;
    $theme          ??= $this->theme;
    $include        ??= $this->include;
    $exclude        ??= $this->exclude;

    // Generate puml diagram
    $connection = $this->doctrine->getConnection($connectionName);
    ($connection instanceof Connection) or throw new RuntimeException('Cannot get required required Connection');
    $dbDraw = new DbDraw($connection);

    $size = Size::from($size);

    return $dbDraw->generatePuml($size, $theme, $include, $exclude);
  }
}
