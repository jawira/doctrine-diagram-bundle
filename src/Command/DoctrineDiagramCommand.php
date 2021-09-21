<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
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
  protected ConnectionRegistry $doctrine;

  public function __construct($doctrine, string $name)
  {
    $this->doctrine = $doctrine;
    parent::__construct($name);
  }

  protected function configure(): void
  {
    $this->setDescription('Create database diagram')
         ->addOption('connection', 'c', InputOption::VALUE_REQUIRED, 'Doctrine connection to use',$this->doctrine->getDefaultConnectionName())
         ->addOption('size', 's', InputOption::VALUE_REQUIRED, 'Diagram size (mini, midi or maxi)', DbDraw::MIDI)
         ->addOption('filename', 'f', InputOption::VALUE_REQUIRED, 'File name (without extension)');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $fs = new Filesystem();
    $io = new SymfonyStyle($input, $output);
    $io->text('<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>');

    $connectionName = $input->getOption('connection');

    /** @var \Doctrine\DBAL\Connection $connection */
    $connection = $this->doctrine->getConnection($connectionName);
    $dbDraw     = new DbDraw($connection);
    $size       = $input->getOption('size') ?: DbDraw::MIDI;
    $content    = $dbDraw->generatePuml($size);
    $filename   = $input->getOption('filename') ?: $connectionName;
    $fullName   = "$filename.puml";

    $fs->dumpFile($fullName, $content);
    $io->success($fullName);

    return Command::SUCCESS;
  }
}
