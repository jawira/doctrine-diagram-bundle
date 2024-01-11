<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class DoctrineDiagramExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container): void
  {
    // @todo: Use AbstractExtension
    $configuration = new Configuration();
    $config        = $this->processConfiguration($configuration, $configs);

    
    $container->setParameter('doctrine_diagram.size', $config['size']);
    $container->setParameter('doctrine_diagram.filename', $config['filename']);
    $container->setParameter('doctrine_diagram.extension', $config['extension']);
    $container->setParameter('doctrine_diagram.server', $config['server']);
    $container->setParameter('doctrine_diagram.connection', $config['connection']);

    $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.xml');
  }
}
