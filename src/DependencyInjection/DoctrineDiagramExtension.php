<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\DependencyInjection;

use Jawira\DoctrineDiagramBundle\Constants\Config as C;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Jawira\DoctrineDiagramBundle\Service\Toolbox;

class DoctrineDiagramExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container): void
  {
    // @todo: Use AbstractExtension
    $configuration = new Configuration();
    $config        = $this->processConfiguration($configuration, $configs);

    $c = Toolbox::concat(...);
    // er
    $container->setParameter($c(C::ROOT, C::ER, C::FILENAME), $config[C::ER][C::FILENAME]);
    $container->setParameter($c(C::ROOT, C::ER, C::SIZE), $config[C::ER][C::SIZE]);
    $container->setParameter($c(C::ROOT, C::ER, C::FORMAT), $config[C::ER][C::FORMAT]);
    $container->setParameter($c(C::ROOT, C::ER, C::THEME), $config[C::ER][C::THEME]);
    $container->setParameter($c(C::ROOT, C::ER, C::CONNECTION), $config[C::ER][C::CONNECTION]);
    $container->setParameter($c(C::ROOT, C::ER, C::EXCLUDE), $config[C::ER][C::EXCLUDE]);
    // class
    $container->setParameter($c(C::ROOT, C::CLASSN, C::FILENAME), $config[C::CLASSN][C::FILENAME]);
    $container->setParameter($c(C::ROOT, C::CLASSN, C::SIZE), $config[C::CLASSN][C::SIZE]);
    $container->setParameter($c(C::ROOT, C::CLASSN, C::FORMAT), $config[C::CLASSN][C::FORMAT]);
    $container->setParameter($c(C::ROOT, C::CLASSN, C::THEME), $config[C::CLASSN][C::THEME]);
    $container->setParameter($c(C::ROOT, C::CLASSN, C::EM), $config[C::CLASSN][C::EM]);
    $container->setParameter($c(C::ROOT, C::CLASSN, C::EXCLUDE), $config[C::CLASSN][C::EXCLUDE]);
    // convert
    $container->setParameter($c(C::ROOT, C::CONVERT, C::CONVERTER), $config[C::CONVERT][C::CONVERTER]);
    $container->setParameter($c(C::ROOT, C::CONVERT, C::JAR), $config[C::CONVERT][C::JAR]);
    $container->setParameter($c(C::ROOT, C::CONVERT, C::SERVER), $config[C::CONVERT][C::SERVER]);


    $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.php');
  }
}
