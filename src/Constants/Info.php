<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * All descriptions for configuration flags and config files.
 */
class Info
{
  public const FILE_NAME = 'Destination file name.';
  public const FORMAT = 'Diagram format (<info>' . Format::SVG . '</info>, <info>' . Format::PNG . '</info> or <info>' . Format::PUML . '</info>).';
  public const SIZE = 'Diagram size (<info>' . Size::MINI . '</info>, <info>' . Size::MIDI . '</info> or <info>' . Size::MAXI . '</info>).';
  public const CONVERTER = 'Which strategy will be used to convert puml to another format (<info>' . Converter::AUTO . '</info>, <info>' . Converter::JAR . '</info> or <info>' . Converter::SERVER . '</info>).';
  public const SERVER = 'PlantUML server URL, used to convert puml diagrams to svg or png.';
  public const JAR = 'Path to plantuml.jar, used to convert puml diagrams to svg or png.';
  public const CONNECTION = 'Doctrine connection to use.';
  public const THEME = 'Change diagram colors and style.';
  public const EXCLUDE = 'Comma separated list of tables to exclude from diagram.';
}
