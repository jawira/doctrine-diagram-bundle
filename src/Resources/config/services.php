<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Jawira\DoctrineDiagramBundle\Command\DoctrineDiagramCommand;
use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Service\DoctrineDiagram;

return function (ContainerConfigurator $container): void {
  $services = $container->services();

  $services->set('jawira.doctrine_diagram.doctrine_diagram', DoctrineDiagram::class)
    ->arg('$doctrine', service('doctrine'))
    ->arg('$size', param('doctrine_diagram.' . Config::SIZE))
    ->arg('$filename', param('doctrine_diagram.' . Config::FILENAME))
    ->arg('$format', param('doctrine_diagram.' . Config::FORMAT))
    ->arg('$server', param('doctrine_diagram.' . Config::SERVER))
    ->arg('$connection', param('doctrine_diagram.' . Config::CONNECTION));

  $services->set('jawira.doctrine_diagram.doctrine_diagram_command', DoctrineDiagramCommand::class)
    ->arg('$doctrineDiagram', service('jawira.doctrine_diagram.doctrine_diagram'))
    ->tag('console.command')
    ->private();
};
