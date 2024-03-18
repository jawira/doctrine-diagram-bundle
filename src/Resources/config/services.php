<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Jawira\DoctrineDiagramBundle\Command\DoctrineDiagramCommand;
use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Service\DoctrineDiagram;
use Jawira\DoctrineDiagramBundle\Service\Toolbox;
use Jawira\PlantUmlToImage\PlantUml;

return function (ContainerConfigurator $container): void {
  $services = $container->services();

  $services->set('.jawira.doctrine_diagram.plantuml_to_image', PlantUml::class);
  $services->set('.jawira.doctrine_diagram.toolbox', Toolbox::class);

  $services->set('jawira.doctrine_diagram.service', DoctrineDiagram::class)
    ->arg('$doctrine', service('doctrine'))
    ->arg('$pumlToImage', service('.jawira.doctrine_diagram.plantuml_to_image'))
    ->arg('$toolbox', service('.jawira.doctrine_diagram.toolbox'))
    ->arg('$size', param('doctrine_diagram.' . Config::SIZE))
    ->arg('$filename', param('doctrine_diagram.' . Config::FILENAME))
    ->arg('$format', param('doctrine_diagram.' . Config::FORMAT))
    ->arg('$jar', param('doctrine_diagram.' . Config::JAR))
    ->arg('$server', param('doctrine_diagram.' . Config::SERVER))
    ->arg('$theme', param('doctrine_diagram.' . Config::THEME))
    ->arg('$connection', param('doctrine_diagram.' . Config::CONNECTION))
    ->arg('$exclude', param('doctrine_diagram.' . Config::EXCLUDE));

  $services->set('jawira.doctrine_diagram.command', DoctrineDiagramCommand::class)
    ->arg('$doctrineDiagram', service('jawira.doctrine_diagram.service'))
    ->tag('console.command')
    ->private();
};
