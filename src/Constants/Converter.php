<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * All valid values for "converter:" key in config file.
 *
 * @internal
 */
class Converter
{
  public const JAR = 'jar';
  public const SERVER = 'server';
  public const AUTO = 'auto';

  /**
   * @return string[]
   */
  public static function allConverter(): array
  {
    return [self::AUTO, self::JAR, self::SERVER];
  }
}
