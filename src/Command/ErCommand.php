<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Info;
use Jawira\DoctrineDiagramBundle\Service\ConversionService;
use Jawira\DoctrineDiagramBundle\Service\DumpService;
use Jawira\DoctrineDiagramBundle\Service\ErDiagram;
use Jawira\DoctrineDiagramBundle\Service\Toolbox;
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
class ErCommand extends Command
{
  public function __construct(
    private readonly ErDiagram         $erDiagram,
    private readonly ConversionService $conversionService,
    private readonly DumpService       $dumpService,
    private readonly Toolbox           $toolbox,
  ) {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      ->setHelp('Create an Entity-Relationship diagram using a Doctrine ORM connection.' . PHP_EOL . PHP_EOL . Info::HELP)
      ->addOption(Config::FILENAME, null, InputOption::VALUE_REQUIRED, Info::FILE_NAME)
      ->addOption(Config::FORMAT, null, InputOption::VALUE_REQUIRED, Info::FORMAT)
      ->addOption(Config::SIZE, null, InputOption::VALUE_REQUIRED, Info::SIZE)
      ->addOption(Config::CONVERTER, null, InputOption::VALUE_REQUIRED, Info::CONVERTER)
      ->addOption(Config::SERVER, null, InputOption::VALUE_REQUIRED, Info::SERVER)
      ->addOption(Config::JAR, null, InputOption::VALUE_REQUIRED, Info::JAR)
      ->addOption(Config::CONNECTION, null, InputOption::VALUE_REQUIRED, Info::CONNECTION)
      ->addOption(Config::THEME, null, InputOption::VALUE_REQUIRED, Info::THEME)
      ->addOption(Config::EXCLUDE, null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, Info::EXCLUDE_ER);
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $errorStyle = (new SymfonyStyle($input, $output))->getErrorStyle();
    $errorStyle->text(Info::CREDITS);

    $connectionName = $this->toolbox->readStringOrNullOption($input, Config::CONNECTION);
    $size           = $this->toolbox->readStringOrNullOption($input, Config::SIZE);
    $format         = $this->toolbox->readStringOrNullOption($input, Config::FORMAT);
    $server         = $this->toolbox->readStringOrNullOption($input, Config::SERVER);
    $converter      = $this->toolbox->readStringOrNullOption($input, Config::CONVERTER);
    $jar            = $this->toolbox->readStringOrNullOption($input, Config::JAR);
    $filename       = $this->toolbox->readStringOrNullOption($input, Config::FILENAME);
    $theme          = $this->toolbox->readStringOrNullOption($input, Config::THEME);
    $exclude        = $this->toolbox->readArrayOrNullOption($input, Config::EXCLUDE);

    $puml     = $this->erDiagram->generatePuml($connectionName, $size, $theme, $exclude);
    $content  = $this->conversionService->convert($puml, $format, $converter, $server, $jar);
    $fullName = $this->dumpService->dumpErDiagram($content, $filename, $format);

    $errorStyle->success("Entity-Relationship diagram: $fullName");

    return Command::SUCCESS;
  }
}
