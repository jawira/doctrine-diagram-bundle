<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramBundle\Service\DoctrineDiagram;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlClient\Format;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author  Jawira Portugal
 */
class DoctrineDiagramCommand extends Command
{
  protected DoctrineDiagram $dd;

  public function __construct(DoctrineDiagram $dd, string $name)
  {
    $this->dd = $dd;
    parent::__construct($name);
  }

  protected function configure(): void
  {
    $connectionName = $this->dd->doctrine->getDefaultConnectionName();

    $this->setDescription('Create database diagram')
         ->addOption('connection', 'c', InputOption::VALUE_REQUIRED, 'Doctrine connection to use', $connectionName)
         ->addOption('size', 's', InputOption::VALUE_REQUIRED, 'Diagram size (mini, midi or maxi)', DbDraw::MIDI)
         ->addOption('filename', 'f', InputOption::VALUE_REQUIRED, 'File name without extension', 'database')
         ->addOption('extension', 'x', InputOption::VALUE_REQUIRED, 'Diagram format (svg, png or puml)', Format::SVG)
         ->addOption('server', 'r', InputOption::VALUE_REQUIRED, 'plantuml-server', Client::SERVER);
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $io->text('<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>');

    $connectionName = strval($input->getOption('connection'));
    $size           = strval($input->getOption('size'));
    $filename       = strval($input->getOption('filename'));
    $format         = strval($input->getOption('extension'));
    $server         = strval($input->getOption('server'));
    $fullName       = "$filename.$format";

    $puml    = $this->dd->generatePuml($connectionName, $size);
    $content = $this->dd->convertWithServer($puml, $format, $server);
    $this->dd->dumpDiagram($fullName, $content);

    $io->success($fullName);

    return Command::SUCCESS;
  }
}
