<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Converter;
use Jawira\DoctrineDiagramBundle\Constants\Fallback;
use Jawira\DoctrineDiagramBundle\Constants\Size;
use Jawira\DoctrineDiagramBundle\Constants\Format;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
    $buildTree = new TreeBuilder(Config::ROOT);
    $rootNode  = $buildTree->getRootNode();
    ($rootNode instanceof ParentNodeDefinitionInterface) or throw new \RuntimeException('Invalid root node when configuring bundle.');

    $rootNode->children()
      ->append($this->erNode())
      ->append($this->classNode())
      ->append($this->convertNode())
      ->end();

    return $buildTree;
  }

  private function classNode(): ArrayNodeDefinition
  {
    $treeBuilder = new TreeBuilder(Config::CLASSN);
    $node        = $treeBuilder->getRootNode();

    $node->addDefaultsIfNotSet()
      ->children()
      ->scalarNode(Config::FILENAME)
      ->defaultValue(Fallback::FILENAME_CLASS)
      ->end()
      ->enumNode(Config::SIZE)
      ->values(Size::allSizes())
      ->defaultValue(Fallback::SIZE)
      ->end()
      ->scalarNode(Config::THEME)
      ->defaultValue(Fallback::THEME)
      ->end()
      ->scalarNode(Config::EM)
      ->defaultValue(null)
      ->end()
      ->arrayNode(Config::EXCLUDE)
      ->scalarPrototype()->end()
      ->end()
      ->end();

    return $node;
  }

  private function erNode(): ArrayNodeDefinition
  {
    $treeBuilder = new TreeBuilder(Config::ER);
    $node        = $treeBuilder->getRootNode();

    $node->addDefaultsIfNotSet()
      ->children()
      ->scalarNode(Config::FILENAME)
      ->defaultValue(Fallback::FILENAME_ER)
      ->end()
      ->enumNode(Config::SIZE)
      ->values(Size::allSizes())
      ->defaultValue(Fallback::SIZE)
      ->end()
      ->scalarNode(Config::THEME)
      ->defaultValue(Fallback::THEME)
      ->end()
      ->scalarNode(Config::CONNECTION)
      ->defaultValue(null)
      ->end()
      ->arrayNode(Config::EXCLUDE)
      ->scalarPrototype()->end()
      ->end()
      ->end();

    return $node;
  }


  private function convertNode(): ArrayNodeDefinition
  {
    $treeBuilder = new TreeBuilder(Config::CONVERT);
    $node        = $treeBuilder->getRootNode();

    $node->addDefaultsIfNotSet()
      ->children()
      ->enumNode(Config::FORMAT)
      ->values(Format::allFormats())
      ->defaultValue(Fallback::FORMAT)
      ->end()
      ->enumNode(Config::CONVERTER)
      ->values(Converter::allConverter())
      ->defaultValue(Fallback::CONVERTER)
      ->end()
      ->scalarNode(Config::JAR)
      ->defaultValue(null)
      ->end()
      ->scalarNode(Config::SERVER)
      ->defaultValue(Fallback::SERVER)
      ->end()
      ->end();

    return $node;
  }
}
