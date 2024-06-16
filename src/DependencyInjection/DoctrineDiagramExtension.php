<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Jawira\DoctrineDiagramBundle\Constants\Config;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class DoctrineDiagramExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container): void
  {
    // @todo: Use AbstractExtension
    $configuration = new Configuration();
    $config        = $this->processConfiguration($configuration, $configs);

    $container->setParameter('doctrine_diagram.' . Config::SIZE, $config[Config::SIZE]);
    $container->setParameter('doctrine_diagram.' . Config::FILENAME, $config[Config::FILENAME]);
    $container->setParameter('doctrine_diagram.' . Config::FORMAT, $config[Config::FORMAT]);
    $container->setParameter('doctrine_diagram.' . Config::CONVERTER, $config[Config::CONVERTER]);
    $container->setParameter('doctrine_diagram.' . Config::JAR, $config[Config::JAR]);
    $container->setParameter('doctrine_diagram.' . Config::SERVER, $config[Config::SERVER]);
    $container->setParameter('doctrine_diagram.' . Config::THEME, $config[Config::THEME]);
    $container->setParameter('doctrine_diagram.' . Config::CONNECTION, $config[Config::CONNECTION]);
    $container->setParameter('doctrine_diagram.' . Config::EXCLUDE, $config[Config::EXCLUDE]);

    $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.php');
  }
}
