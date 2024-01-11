<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Fallback;
use Jawira\DoctrineDiagramBundle\Constants\Size;
use Jawira\DoctrineDiagramBundle\Constants\Format;
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
      ->enumNode(Config::SIZE)
      ->values([Size::MINI, Size::MIDI, Size::MAXI])
      ->defaultValue(Fallback::SIZE)
      ->end()
      ->scalarNode(Config::FILENAME)
      ->defaultValue(Fallback::FILENAME)
      ->end()
      ->enumNode(Config::FORMAT)
      ->values([Format::PUML, Format::PNG, Format::SVG])
      ->defaultValue(Fallback::FORMAT)
      ->end()
      ->scalarNode(Config::SERVER)
      ->defaultValue(Fallback::SERVER)
      ->end()
      ->scalarNode(Config::CONNECTION)
      ->defaultValue(Fallback::CONNECTION)
      ->end()
      ->end();

    return $buildTree;
  }
}
