<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use Jawira\DoctrineDiagramBundle\Constants\Format;
use ReflectionClass;
use function boolval;
use function in_array;
use function preg_match;
use function str_ends_with;

/**
 * @internal
 */
class Toolbox
{
  /**
   * Will append extension to filename when required.
   */
  public function appendExtension(string $filename, string $extension): string
  {
    (trim($filename) !== '') or throw new \RuntimeException('Filename cannot be empty');
    (trim($extension) !== '') or throw new \RuntimeException('Extension cannot be empty');

    return str_ends_with($filename, ".$extension") ? $filename : "$filename.$extension";
  }

  /**
   * Tells if provided string is a wrapper.
   *
   * A wrapper starts with a protocol, for example "php://".
   *
   * @see https://www.php.net/manual/en/wrappers.php
   * @see https://www.php.net/manual/en/function.stream-wrapper-register.php
   */
  public function isWrapper(string $string): bool
  {
    return boolval(preg_match('#^[a-zA-Z0-9.+-]+://#', $string));
  }

  /**
   * Tells you if provided format is valid.
   */
  public function isValidFormat(string $format): bool
  {
    return in_array($format, Format::allFormats(), true);
  }
}
