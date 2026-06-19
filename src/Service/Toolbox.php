<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

use InvalidArgumentException;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use ReflectionClass;
use Symfony\Component\Console\Input\InputInterface;
use UnexpectedValueException;
use function boolval;
use function implode;
use function in_array;
use function is_array;
use function is_string;
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
    $reflectionClass = new ReflectionClass(Format::class);
    return in_array($format, $reflectionClass->getConstants(), true);
  }

  /**
   * Concatenate string using a dot.
   */
  static public function concat(string ...$params): string
  {
    return implode('.', $params);
  }

  /**
   * Read options that must be string.
   *
   * Null must be returned when option is not set.
   * Custom function to extract console options and make PHPStan happy!
   */
  public function readStringOrNullOption(InputInterface $input, string $optionName): ?string
  {
    $value = $input->getOption($optionName);

    return is_string($value) ? $value : null;
  }

  /**
   * Read an array of strings from Command input.
   *
   * Null value is important, it must be returned when option is not set.
   * This method will make PHPStan happy.
   *
   * @return string[]|null
   */
  public function readArrayOrNullOption(InputInterface $input, string $optionName): ?array
  {
    $value = $input->getOption($optionName);
    if ($value === null) {
      return null;
    }
    is_array($value) or throw new InvalidArgumentException('Input value must be array');
    foreach ($value as $item) {
      is_string($item) or throw new UnexpectedValueException('Array element must be string');
    }

    /** @var string[] $value */
    return $value;
  }
}
