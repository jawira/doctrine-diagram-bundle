<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Jawira\DoctrineDiagramBundle\Command\ErDiagramCommand;
use Jawira\DoctrineDiagramBundle\Constants\Config as C;
use Jawira\DoctrineDiagramBundle\Service\ConversionService;
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

  $services->set('jawira.doctrine_diagram.conversion_service', ConversionService::class)
    // services
    ->arg('$pumlToImage', service('.jawira.doctrine_diagram.plantuml_to_image'))
    ->arg('$toolbox', service('.jawira.doctrine_diagram.toolbox'))
    // parameters
    ->arg('$filename', param($c(C::ROOT, C::ER, C::FILENAME)))
    ->arg('$format', param($c(C::ROOT, C::ER, C::FORMAT)))
    ->arg('$converter', param($c(C::ROOT, C::CONVERT, C::CONVERTER)))
    ->arg('$jar', param($c(C::ROOT, C::CONVERT, C::JAR)))
    ->arg('$server', param($c(C::ROOT, C::CONVERT, C::SERVER)));


  $services->set('jawira.doctrine_diagram.command', ErDiagramCommand::class)
    ->arg('$erDiagram', service('jawira.doctrine_diagram.er_diagram'))
    ->arg('$conversionService', service('jawira.doctrine_diagram.conversion_service'))
    ->tag('console.command')
    ->private();
};
