<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Converter;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use Jawira\DoctrineDiagramBundle\Constants\Size;
use Jawira\DoctrineDiagramBundle\Service\DoctrineDiagram;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * @author  Jawira Portugal
 */
#[AsCommand('doctrine:diagram', 'Create a database diagram.')]
class DoctrineDiagramCommand extends Command
{
  public function __construct(private DoctrineDiagram $doctrineDiagram)
  {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      ->setHelp(<<<'HELP'
        Create a database diagram using a Doctrine ORM connection.

        <comment>THEMES</comment>
        Well-known themes: <info>amiga</info>, <info>blueprint</info>, <info>cerulean</info>, <info>crt-amber</info>, <info>crt-green</info>, <info>cyborg</info>, <info>lightgray</info>, <info>plain</info>, <info>silver</info>, <info>vibrant</info>.
        Please note that the availability of themes may vary depending on the specific version of PlantUML being utilized to render the diagrams.

        <comment>FORMATS</comment>
        If you are experiencing problems creating a diagram, try using PlantUML (<info>puml</info>) format.
        Unlike <info>png</info> and <info>svg</info> formats, PlantUML doesn't require an internet connection.
        HELP
      )
      ->addUsage(sprintf('--%s=project.png --%s=png', Config::FILENAME, Config::FORMAT))
      ->addUsage(sprintf('--%s=%s', Config::SIZE, Size::MINI))
      ->addOption(Config::FILENAME, null, InputOption::VALUE_REQUIRED, 'Destination file name.')
      ->addOption(Config::FORMAT, null, InputOption::VALUE_REQUIRED, sprintf('Diagram format (<info>%s</info>, <info>%s</info> or <info>%s</info>).', Format::SVG, Format::PNG, Format::PUML))
      ->addOption(Config::SIZE, null, InputOption::VALUE_REQUIRED, sprintf('Diagram size (<info>%s</info>, <info>%s</info> or <info>%s</info>).', Size::MINI, Size::MIDI, Size::MAXI))
      ->addOption(Config::CONVERTER, null, InputOption::VALUE_REQUIRED, 'Which strategy will be used to convert puml to another format.', Converter::AUTO, Converter::JAR, Converter::SERVER)
      ->addOption(Config::SERVER, null, InputOption::VALUE_REQUIRED, 'PlantUML server URL, used to convert puml diagrams to svg or png.')
      ->addOption(Config::JAR, null, InputOption::VALUE_REQUIRED, 'Path to plantuml.jar, used to convert puml diagrams to svg or png.')
      ->addOption(Config::CONNECTION, null, InputOption::VALUE_REQUIRED, 'Doctrine connection to use.')
      ->addOption(Config::THEME, null, InputOption::VALUE_REQUIRED, 'Change diagram colors and style.')
      ->addOption(Config::EXCLUDE, null, InputOption::VALUE_REQUIRED, 'Comma separated list of tables to exclude from diagram.');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $errorStyle = (new SymfonyStyle($input, $output))->getErrorStyle();
    $errorStyle->text('<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>');

    $connectionName = $this->stringOrNullOption($input, Config::CONNECTION);
    $size           = $this->stringOrNullOption($input, Config::SIZE);
    $format         = $this->stringOrNullOption($input, Config::FORMAT);
    $server         = $this->stringOrNullOption($input, Config::SERVER);
    $converter      = $this->stringOrNullOption($input, Config::CONVERTER);
    $jar            = $this->stringOrNullOption($input, Config::JAR);
    $filename       = $this->stringOrNullOption($input, Config::FILENAME);
    $theme          = $this->stringOrNullOption($input, Config::THEME);
    $exclude        = $this->stringOrNullOption($input, Config::EXCLUDE);

    $excludeArray = is_string($exclude) ? explode(',', $exclude) : null;

    $puml     = $this->doctrineDiagram->generatePuml($connectionName, $size, $theme, $excludeArray);
    $content  = match ($converter) {
      Converter::AUTO => $this->doctrineDiagram->convertAuto($puml, $format, $server, $jar),
      Converter::JAR => $this->doctrineDiagram->convertWithJar($puml, $format, $jar),
      Converter::SERVER => $this->doctrineDiagram->convertWithServer($puml, $format, $server),
    };
    $fullName = $this->doctrineDiagram->dumpDiagram($content, $filename, $format);

    $errorStyle->success("Diagram: $fullName");

    return Command::SUCCESS;
  }

  /**
   * Custom function to extract console options and make PHPStan happy!
   */
  private function stringOrNullOption(InputInterface $input, string $optionName): ?string
  {
    $value = $input->getOption($optionName);

    return is_string($value) ? $value : null;
  }
}
