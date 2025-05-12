<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * All fallback values for configuration file.
 *
 * @internal
 */
class Fallback
{
  public const SIZE = Size::MIDI;
  public const FILENAME_CLASS = '%kernel.project_dir%/class';
  public const FILENAME_ER = '%kernel.project_dir%/er';
  public const FORMAT = Format::SVG;
  public const SERVER = 'http://www.plantuml.com/plantuml';
  public const THEME = '_none_';
  public const CONVERTER = Converter::AUTO;
}
