<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Size;
use Jawira\DoctrineDiagramBundle\Service\DoctrineDiagram;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlClient\Format;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;


/**
 * @author  Jawira Portugal
 */
#[AsCommand('doctrine:diagram')]
class DoctrineDiagramCommand extends Command
{

  public function __construct(private DoctrineDiagram $doctrineDiagram)
  {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this->setDescription('Create database diagram.')
      ->addUsage(sprintf('--%s=%s', Config::SIZE, Size::MINI))
      ->addUsage(sprintf('--%s=my-diagram --%s=png', Config::FILENAME, Config::FORMAT))
      ->addUsage(sprintf('--%s=default', Config::CONNECTION))
      ->addOption(Config::SIZE, null, InputOption::VALUE_REQUIRED, 'Diagram size (mini, midi or maxi)')
      ->addOption(Config::FILENAME, null, InputOption::VALUE_REQUIRED, 'Destination file name.')
      ->addOption(Config::FORMAT, null, InputOption::VALUE_REQUIRED, 'Diagram format (svg, png or puml).')
      ->addOption(Config::CONNECTION, null, InputOption::VALUE_REQUIRED, 'Doctrine connection to use.')
      ->addOption(Config::SERVER, null, InputOption::VALUE_REQUIRED, 'PlantUML server URL, used to convert puml diagrams to svg and png.');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $io->text('<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>');

    $connectionName = $input->getOption(Config::CONNECTION);
    $size           = $input->getOption(Config::SIZE);
    $format         = $input->getOption(Config::FORMAT);
    $server         = $input->getOption(Config::SERVER);
    $filename       = $input->getOption(Config::FILENAME);

    $puml     = $this->doctrineDiagram->generatePuml($connectionName, $size);
    $content  = $this->doctrineDiagram->convertWithServer($puml, $format, $server);
    $fullName = $this->doctrineDiagram->dumpDiagram($content, $filename, $format);

    $io->success("Diagram: $fullName");

    return Command::SUCCESS;
  }
}
