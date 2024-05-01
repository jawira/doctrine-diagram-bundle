<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * All valid formats for a diagram.
 *
 * @internal
 */
class Format
{
  public const PUML = 'puml';
  public const SVG = 'svg';
  public const PNG = 'png';

  /**
   * @return string[]
   */
  public static function allFormats(): array
  {
    return [self::PUML, self::PNG, self::SVG];
  }
}
