<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Jawira\DoctrineDiagramBundle\Command\ClassCommand;
use Jawira\DoctrineDiagramBundle\Command\ErCommand;
use Jawira\DoctrineDiagramBundle\Constants\Config as C;
use Jawira\DoctrineDiagramBundle\Service\ClassDiagram;
use Jawira\DoctrineDiagramBundle\Service\ConversionService;
use Jawira\DoctrineDiagramBundle\Service\DumpService;
use Jawira\DoctrineDiagramBundle\Service\ErDiagram;
use Jawira\DoctrineDiagramBundle\Service\Toolbox;
use Jawira\PlantUmlToImage\PlantUml;

return function (ContainerConfigurator $container): void {
  $services = $container->services();

  $services->set('.jawira.doctrine_diagram.plantuml_to_image', PlantUml::class);
  $services->set('.jawira.doctrine_diagram.toolbox', Toolbox::class);

  $c = Toolbox::concat(...);
  $services->set('jawira.doctrine_diagram.er_diagram', ErDiagram::class)
    // services
    ->arg('$doctrine', service('doctrine'))
    // parameters
    ->arg('$size', param($c(C::ROOT, C::ER, C::SIZE)))
    ->arg('$theme', param($c(C::ROOT, C::ER, C::THEME)))
    ->arg('$connection', param($c(C::ROOT, C::ER, C::CONNECTION)))
    ->arg('$exclude', param($c(C::ROOT, C::ER, C::EXCLUDE)));

  $services->set('jawira.doctrine_diagram.class_diagram', ClassDiagram::class)
    // services
    ->arg('$doctrine', service('doctrine'))
    // parameters
    ->arg('$size', param($c(C::ROOT, C::CLASSN, C::SIZE)))
    ->arg('$theme', param($c(C::ROOT, C::CLASSN, C::THEME)))
    ->arg('$em', param($c(C::ROOT, C::CLASSN, C::EM)))
    ->arg('$exclude', param($c(C::ROOT, C::CLASSN, C::EXCLUDE)));

  $services->set('jawira.doctrine_diagram.conversion_service', ConversionService::class)
    // services
    ->arg('$pumlToImage', service('.jawira.doctrine_diagram.plantuml_to_image'))
    ->arg('$toolbox', service('.jawira.doctrine_diagram.toolbox'))
    // parameters
    ->arg('$format', param($c(C::ROOT, C::CONVERT, C::FORMAT)))
    ->arg('$converter', param($c(C::ROOT, C::CONVERT, C::CONVERTER)))
    ->arg('$jar', param($c(C::ROOT, C::CONVERT, C::JAR)))
    ->arg('$server', param($c(C::ROOT, C::CONVERT, C::SERVER)));

  $services->set('jawira.doctrine_diagram.dump_service', DumpService::class)
    // services
    ->arg('$toolbox', service('.jawira.doctrine_diagram.toolbox'))
    // parameters
    ->arg('$erFilename', param($c(C::ROOT, C::ER, C::FILENAME)))
    ->arg('$classFilename', param($c(C::ROOT, C::CLASSN, C::FILENAME)))
    ->arg('$format', param($c(C::ROOT, C::CONVERT, C::FORMAT)));

  $services->set('jawira.doctrine_diagram.er_command', ErCommand::class)
    ->arg('$erDiagram', service('jawira.doctrine_diagram.er_diagram'))
    ->arg('$conversionService', service('jawira.doctrine_diagram.conversion_service'))
    ->arg('$dumpService', service('jawira.doctrine_diagram.dump_service'))
    ->tag('console.command')
    ->private();

  $services->set('jawira.doctrine_diagram.class_command', ClassCommand::class)
    ->arg('$classDiagram', service('jawira.doctrine_diagram.class_diagram'))
    ->arg('$conversionService', service('jawira.doctrine_diagram.conversion_service'))
    ->arg('$dumpService', service('jawira.doctrine_diagram.dump_service'))
    ->tag('console.command')
    ->private();
};
