<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Jawira\EntityDraw\EntityDraw;

class ClassDiagram
{
  public function __construct(
    private readonly ManagerRegistry $doctrine,
    private readonly string          $size,
    private readonly string          $theme,
    private readonly ?string         $em,
    /** @var string[] */
    private readonly array           $exclude,
  ) {
  }

  /**
   * @param null|string[] $exclude List of classes to exclude from the class diagram.
   */
  public function generatePuml(?string $emName, ?string $size, ?string $theme, ?array $exclude): string
  {
    // Fallback values from doctrine_diagram.yaml
    $emName  ??= $this->em;
    $size    ??= $this->size;
    $theme   ??= $this->theme;
    $exclude ??= $this->exclude;

    // Generate puml diagram
    $entityManager = $this->doctrine->getManager($emName);
    ($entityManager instanceof EntityManagerInterface) or throw new \RuntimeException('Cannot get required Entity Manager');
    $entityDraw = new EntityDraw($entityManager);

    return $entityDraw->generatePuml($size, $theme, $exclude);
  }
}
