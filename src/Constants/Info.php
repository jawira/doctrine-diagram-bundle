<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Constants;

/**
 * All descriptions for configuration flags and config files.
 *
 * @internal
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
  public const EM = 'Entity Manager to use.';
  public const THEME = 'Theme name, this will change colors and style.';
  public const INCLUDE_ER = 'Name of the table to include in the diagram.';
  public const EXCLUDE_ER = 'Name of the table to exclude from the diagram.';
  public const INCLUDE_CLASS = 'Name of the class to include in the diagram.';
  public const EXCLUDE_CLASS = 'Name of the class to exclude from the diagram.';
  public const  HELP = <<<'HELP'
    <comment>THEMES</comment>
    Well-known themes: <info>amiga</info>, <info>blueprint</info>, <info>cerulean</info>, <info>crt-amber</info>, <info>crt-green</info>, <info>cyborg</info>, <info>lightgray</info>, <info>plain</info>, <info>silver</info>, <info>vibrant</info>.
    Please note that the availability of themes may vary depending on the specific version of PlantUML being used to render the diagrams.
    More about PlantUML themes: https://plantuml.com/es/theme

    <comment>FORMATS</comment>
    Use PlantUML format <info>puml</info> if you are experiencing problems when creating a diagram.
    Unlike <info>png</info> and <info>svg</info> formats, <info>puml</info> doesn't require an internet connection.
    HELP;
  public const CREDITS = '<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>';
}
