<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class DoctrineDiagramExtension extends Extension
{
  /**
   * @param mixed[] $configs
   */
  public function load(array $configs, ContainerBuilder $container): void
  {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $container->setParameter('doctrine_diagram.size', $config['size']);
    $container->setParameter('doctrine_diagram.filename', $config['filename']);
    $container->setParameter('doctrine_diagram.extension', $config['extension']);
    $container->setParameter('doctrine_diagram.server', $config['server']);
    $container->setParameter('doctrine_diagram.connection', $config['connection']);

    $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.xml');
  }
}
