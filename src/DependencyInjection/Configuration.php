<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Doctrine\Persistence\ConnectionRegistry;
use Jawira\DbDraw\DbDraw;
use Jawira\DoctrineDiagramBundle\Service\DoctrineDiagram;
use Jawira\PlantUmlClient\Client;
use Jawira\PlantUmlClient\Format;
use Symfony\Component\Config\Definition\Builder\ParentNodeDefinitionInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author  Jawira PORTUGAL
 */
class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder(): TreeBuilder
  {
    $buildTree = (new TreeBuilder('doctrine_diagram'));
    /** @var ParentNodeDefinitionInterface $rootNode */
    $rootNode = $buildTree->getRootNode();
    $rootNode->children()
      ->enumNode('size')
      ->values([DbDraw::MINI, DbDraw::MIDI, DbDraw::MAXI])
      ->defaultValue(DbDraw::MIDI)
      ->end()
      ->scalarNode('filename')
      ->defaultValue('database')
      ->end()
      ->enumNode('extension')
      ->values([DoctrineDiagram::PUML, Format::PNG, Format::SVG])
      ->defaultValue(Format::SVG)
      ->end()
      ->scalarNode('server')
      ->defaultValue(Client::SERVER)
      ->end()
      ->scalarNode('connection')
      ->defaultValue('default')
      ->end()
      ->end();

    return $buildTree;
  }
}
