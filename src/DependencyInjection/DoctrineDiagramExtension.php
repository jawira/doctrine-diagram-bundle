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
    /**
     * @var array{
     *    er: array{
     *      size: null|non-empty-string,
     *      filename: null|non-empty-string,
     *      theme: null|non-empty-string,
     *      connection: null|non-empty-string,
     *      include: null|list<string>,
     *      exclude: null|list<string>
     *    },
     *    class: array{
     *      size: null|non-empty-string,
     *      filename: null|non-empty-string,
     *      theme: null|non-empty-string,
     *      em: null|non-empty-string,
     *      include: null|list<string>,
     *      exclude: null|list<string>
     *    },
     *    convert: array{
     *      format: non-empty-string,
     *      converter: non-empty-string,
     *      jar: non-empty-string,
     *      server: non-empty-string
     *    }
     *  } $config
     */
    $config = $this->processConfiguration(new Configuration(), $configs);

    // er
    $container->setParameter(Toolbox::concat(C::ROOT, C::ER, C::SIZE), $config[C::ER][C::SIZE]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::ER, C::FILENAME), $config[C::ER][C::FILENAME]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::ER, C::THEME), $config[C::ER][C::THEME]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::ER, C::CONNECTION), $config[C::ER][C::CONNECTION]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::ER, C::INCLUDE), $config[C::ER][C::INCLUDE]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::ER, C::EXCLUDE), $config[C::ER][C::EXCLUDE]);
    // class
    $container->setParameter(Toolbox::concat(C::ROOT, C::CLASSN, C::SIZE), $config[C::CLASSN][C::SIZE]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CLASSN, C::FILENAME), $config[C::CLASSN][C::FILENAME]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CLASSN, C::THEME), $config[C::CLASSN][C::THEME]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CLASSN, C::EM), $config[C::CLASSN][C::EM]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CLASSN, C::INCLUDE), $config[C::CLASSN][C::INCLUDE]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CLASSN, C::EXCLUDE), $config[C::CLASSN][C::EXCLUDE]);
    // convert
    $container->setParameter(Toolbox::concat(C::ROOT, C::CONVERT, C::FORMAT), $config[C::CONVERT][C::FORMAT]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CONVERT, C::CONVERTER), $config[C::CONVERT][C::CONVERTER]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CONVERT, C::JAR), $config[C::CONVERT][C::JAR]);
    $container->setParameter(Toolbox::concat(C::ROOT, C::CONVERT, C::SERVER), $config[C::CONVERT][C::SERVER]);

    $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.php');
  }
}
