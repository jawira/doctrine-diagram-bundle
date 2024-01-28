<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

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
}
