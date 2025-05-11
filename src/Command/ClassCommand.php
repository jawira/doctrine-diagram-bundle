<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Command;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Info;
use Jawira\DoctrineDiagramBundle\Service\ClassDiagram;
use Jawira\DoctrineDiagramBundle\Service\ConversionService;
use Jawira\DoctrineDiagramBundle\Service\DumpService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function explode;
use function is_string;


/**
 * @author  Jawira Portugal
 */
#[AsCommand('doctrine:diagram:class', 'Create a Class diagram.')]
class ClassCommand extends Command
{
  public function __construct(
    private readonly ClassDiagram      $classDiagram,
    private readonly ConversionService $conversionService,
    private readonly DumpService       $dumpService,
  ) {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      ->addOption(Config::FILENAME, null, InputOption::VALUE_REQUIRED, Info::FILE_NAME)
      ->addOption(Config::FORMAT, null, InputOption::VALUE_REQUIRED, Info::FORMAT)
      ->addOption(Config::SIZE, null, InputOption::VALUE_REQUIRED, Info::SIZE)
      ->addOption(Config::CONVERTER, null, InputOption::VALUE_REQUIRED, Info::CONVERTER)
      ->addOption(Config::SERVER, null, InputOption::VALUE_REQUIRED, Info::SERVER)
      ->addOption(Config::JAR, null, InputOption::VALUE_REQUIRED, Info::JAR)
      ->addOption(Config::EM, null, InputOption::VALUE_REQUIRED, Info::EM)
      ->addOption(Config::THEME, null, InputOption::VALUE_REQUIRED, Info::THEME)
      ->addOption(Config::EXCLUDE, null, InputOption::VALUE_REQUIRED, Info::EXCLUDE);
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $errorStyle = (new SymfonyStyle($input, $output))->getErrorStyle();
    $errorStyle->text('<info>Doctrine Diagram Bundle</info> by <info>Jawira Portugal</info>');

    $emName    = $this->stringOrNullOption($input, Config::EM);
    $size      = $this->stringOrNullOption($input, Config::SIZE);
    $format    = $this->stringOrNullOption($input, Config::FORMAT);
    $server    = $this->stringOrNullOption($input, Config::SERVER);
    $converter = $this->stringOrNullOption($input, Config::CONVERTER);
    $jar       = $this->stringOrNullOption($input, Config::JAR);
    $filename  = $this->stringOrNullOption($input, Config::FILENAME);
    $theme     = $this->stringOrNullOption($input, Config::THEME);
    $exclude   = $this->stringOrNullOption($input, Config::EXCLUDE);

    $excludeArray = is_string($exclude) ? explode(',', $exclude) : null;

    $puml     = $this->classDiagram->generatePuml($emName, $size, $theme, $excludeArray);
    $content  = $this->conversionService->convert($puml, $format, $converter, $server, $jar);
    $fullName = $this->dumpService->dumpClassDiagram($content, $filename, $format);

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
