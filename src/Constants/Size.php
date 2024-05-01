<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * All different versions for a Diagram.
 *
 * @internal
 */
class Size
{
  public const MINI = 'mini';
  public const MIDI = 'midi';
  public const MAXI = 'maxi';

  /**
   * @return string[]
   */
  public static function allSizes(): array
  {
    return [Size::MINI, Size::MIDI, Size::MAXI];
  }
}
