<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Info;
use Jawira\DoctrineDiagramBundle\Constants\Size;
use Jawira\DoctrineDiagramBundle\Service\ConversionService;
use Jawira\DoctrineDiagramBundle\Service\ErDiagram;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * @author  Jawira Portugal
 */
#[AsCommand('doctrine:diagram:er', 'Create an Entity-Relationship diagram.')]
class ErDiagramCommand extends Command
{
  public function __construct(
    private ErDiagram         $erDiagram,
    private ConversionService $conversionService,
  ) {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      ->setHelp(<<<'HELP'
        Create a database diagram using a Doctrine ORM connection.

        <comment>THEMES</comment>
        Well-known themes: <info>amiga</info>, <info>blueprint</info>, <info>cerulean</info>, <info>crt-amber</info>, <info>crt-green</info>, <info>cyborg</info>, <info>lightgray</info>, <info>plain</info>, <info>silver</info>, <info>vibrant</info>.
        Please note that the availability of themes may vary depending on the specific version of PlantUML being used to render the diagrams.

        <comment>FORMATS</comment>
        Use PlantUML format <info>puml</info> if you are experiencing problems when creating a diagram.
        Unlike <info>png</info> and <info>svg</info> formats, <info>puml</info> doesn't require an internet connection.
        HELP
      )
      ->addUsage(sprintf('--%s=project.png --%s=png', Config::FILENAME, Config::FORMAT))
      ->addUsage(sprintf('--%s=%s', Config::SIZE, Size::MINI))
      ->addOption(Config::FILENAME, null, InputOption::VALUE_REQUIRED, Info::FILE_NAME)
      ->addOption(Config::FORMAT, null, InputOption::VALUE_REQUIRED, Info::FORMAT)
      ->addOption(Config::SIZE, null, InputOption::VALUE_REQUIRED, Info::SIZE)
      ->addOption(Config::CONVERTER, null, InputOption::VALUE_REQUIRED, Info::CONVERTER)
      ->addOption(Config::SERVER, null, InputOption::VALUE_REQUIRED, Info::SERVER)
      ->addOption(Config::JAR, null, InputOption::VALUE_REQUIRED, Info::JAR)
      ->addOption(Config::CONNECTION, null, InputOption::VALUE_REQUIRED, Info::CONNECTION)
      ->addOption(Config::THEME, null, InputOption::VALUE_REQUIRED, Info::THEME)
      ->addOption(Config::EXCLUDE, null, InputOption::VALUE_REQUIRED, Info::EXCLUDE);
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

    $puml     = $this->erDiagram->generatePuml($connectionName, $size, $theme, $excludeArray);
    $content  = $this->conversionService->convert($puml, $format, $converter, $server, $jar);
    $fullName = $this->conversionService->dumpDiagram($content, $filename, $format);

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
