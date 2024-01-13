<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Jawira\DoctrineDiagramBundle\Constants\Config;
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

        If you are experiencing problems creating a diagram, try using PlantUML (<info>puml</info>) format.
        Unlike <info>png</info> and <info>svg</info> formats, PlantUML doesn't require an internet connection.
        HELP
      )
      ->addUsage(sprintf('--%s=%s', Config::SIZE, Size::MINI))
      ->addUsage(sprintf('--%s=my-diagram --%s=png', Config::FILENAME, Config::FORMAT))
      ->addUsage(sprintf('--%s=default', Config::CONNECTION))
      ->addOption(Config::FILENAME, null, InputOption::VALUE_REQUIRED, 'Destination file name.')
      ->addOption(Config::FORMAT, null, InputOption::VALUE_REQUIRED, 'Diagram format (svg, png or puml).')
      ->addOption(Config::SIZE, null, InputOption::VALUE_REQUIRED, 'Diagram size (mini, midi or maxi).')
      ->addOption(Config::SERVER, null, InputOption::VALUE_REQUIRED, 'PlantUML server URL, used to convert puml diagrams to svg and png.')
      ->addOption(Config::CONNECTION, null, InputOption::VALUE_REQUIRED, 'Doctrine connection to use.');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $io->text('<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>');

    $connectionName = $this->stringOrNullOption($input, Config::CONNECTION);
    $size           = $this->stringOrNullOption($input, Config::SIZE);
    $format         = $this->stringOrNullOption($input, Config::FORMAT);
    $server         = $this->stringOrNullOption($input, Config::SERVER);
    $filename       = $this->stringOrNullOption($input, Config::FILENAME);

    $puml     = $this->doctrineDiagram->generatePuml($connectionName, $size);
    $content  = $this->doctrineDiagram->convertWithServer($puml, $format, $server);
    $fullName = $this->doctrineDiagram->dumpDiagram($content, $filename, $format);

    $io->success("Diagram: $fullName");

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
