<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Jawira\DoctrineDiagramContracts\Size;
use Jawira\EntityDraw\EntityDraw;

class ClassDiagram
{
  public function __construct(
    private readonly ManagerRegistry $doctrine,
    private readonly string          $size,
    private readonly string          $theme,
    private readonly ?string         $em,
    /** @var string[] */
    private readonly array           $include,
    /** @var string[] */
    private readonly array           $exclude,
  ) {
  }

  /**
   * @param null|string[] $include List of classes to add to the class diagram.
   * @param null|string[] $exclude List of classes to remove from the class diagram.
   */
  public function generatePuml(?string $emName, ?string $size, ?string $theme, ?array $include, ?array $exclude): string
  {
    // Fallback values from doctrine_diagram.yaml
    $emName  ??= $this->em;
    $size    ??= $this->size;
    $theme   ??= $this->theme;
    $include ??= $this->include;
    $exclude ??= $this->exclude;

    // Generate puml diagram
    $entityManager = $this->doctrine->getManager($emName);
    ($entityManager instanceof EntityManagerInterface) or throw new \RuntimeException('Cannot get required Entity Manager');
    $entityDraw = new EntityDraw($entityManager);

    $size = Size::from($size);

    return $entityDraw->generatePuml($size, $theme, $include, $exclude);
  }
}
