<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ParentNodeDefinitionInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author  Jawira PORTUGAL
 */
class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder()
  {
    $buildTree = (new TreeBuilder('doctrine_diagram'));
    /** @var ParentNodeDefinitionInterface $rootNode */
    $rootNode = $buildTree->getRootNode();
    $rootNode->children()
             ->enumNode('format')
             ->values(['puml', 'png', 'svg'])
             ->defaultValue('svg')
             ->end()
             ->enumNode('converter')
             ->values(['server', 'executable'])
             ->defaultValue('executable')
             ->end()
             ->scalarNode('theme')
             ->end()
             ->scalarNode('server')
             ->defaultValue('http://www.plantuml.com/plantuml')
             ->end()
             ->scalarNode('executable')
             ->defaultValue('vendor/bin/plantuml')
             ->end()
             ->scalarNode('connection')
             ->defaultValue('default')
             ->end()
             ->end();

    return $buildTree;
  }
}
