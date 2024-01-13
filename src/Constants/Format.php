<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

class Format
{
  public const PUML = 'puml';
  public const SVG = 'svg';
  public const PNG = 'png';

  /**
   * Tells you if provided format is valid.
   */
  static public function isValid(string $format): bool
  {
    return match ($format) {
      self::PUML, self::SVG, self::PNG => true,
      default => false,
    };
  }
}
