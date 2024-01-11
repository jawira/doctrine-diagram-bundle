<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Jawira\DoctrineDiagramBundle\Constants\Fallback;
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


    $container->setParameter('doctrine_diagram.' . Config::SIZE, $config[Config::SIZE]);
    $container->setParameter('doctrine_diagram.' . Config::FILENAME, $config[Config::FILENAME]);
    $container->setParameter('doctrine_diagram.' . Config::EXTENSION, $config[Config::EXTENSION]);
    $container->setParameter('doctrine_diagram.' . Config::SERVER, $config[Config::SERVER]);
    $container->setParameter('doctrine_diagram.' . Config::CONNECTION, $config[Config::CONNECTION]);

    $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.xml');
  }
}
