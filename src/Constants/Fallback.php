<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * @internal
 */
class Fallback
{
  public const SIZE = Size::MIDI;
  public const FILENAME = '%kernel.project_dir%/database';
  public const FORMAT = Format::SVG;
  public const SERVER = 'http://www.plantuml.com/plantuml';
  public const THEME = '_none_';
}
