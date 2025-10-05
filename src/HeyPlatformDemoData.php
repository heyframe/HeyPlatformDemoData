<?php declare(strict_types=1);

namespace Hey\PlatformDemoData;

use Hey\PlatformDemoData\Bootstrap\AbstractBootstrap;
use Hey\PlatformDemoData\Bootstrap\CategoryBootstrap;
use Hey\PlatformDemoData\Bootstrap\ChannelBootstrap;
use Hey\PlatformDemoData\Bootstrap\CmsPageBootstrap;
use Hey\PlatformDemoData\Bootstrap\CustomerBootstrap;
use Hey\PlatformDemoData\Bootstrap\DomainBootstrap;
use Hey\PlatformDemoData\Bootstrap\MediaBootstrap;
use Hey\PlatformDemoData\Bootstrap\NavigationBootstrap;
use Hey\PlatformDemoData\Bootstrap\OrderBootstrap;
use Hey\PlatformDemoData\Bootstrap\ProductBootstrap;
use Hey\PlatformDemoData\Bootstrap\PromotionBoostrap;
use Hey\PlatformDemoData\Bootstrap\PropertyBootstrap;
use Hey\PlatformDemoData\Bootstrap\RuleBootstrap;
use HeyFrame\Core\Framework\Plugin;
use HeyFrame\Core\Framework\Plugin\Context\InstallContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HeyPlatformDemoData extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        $bootstrapper = $this->getBootstrapClasses($installContext);
        foreach ($bootstrapper as $bootstrap) {
            $bootstrap->preInstall();
            $bootstrap->install();
        }
    }

    public function uninstall(Plugin\Context\UninstallContext $uninstallContext): void
    {
        $bootstrapper = $this->getBootstrapClasses($uninstallContext);
        foreach (array_reverse($bootstrapper) as $bootstrap) {
            $bootstrap->preUninstall();
            $bootstrap->uninstall($uninstallContext->keepUserData());
            $bootstrap->postUninstall();
        }
    }

    /**
     * @return AbstractBootstrap[]
     */
    protected function getBootstrapClasses(InstallContext $context): array
    {
        \assert($this->container instanceof ContainerInterface, 'Container is not set yet, please call setContainer() before calling boot(), see `platform/Core/Kernel.php:186`.');
        /** @var AbstractBootstrap[] $bootstrapper */
        $bootstrapper = [
            new ChannelBootstrap(),
            new MediaBootstrap(),
            //            new CmsPageBoostrap(),
            new DomainBootstrap(),
            new CategoryBootstrap(),
            new NavigationBootstrap(),
            new CustomerBootstrap(),
            new RuleBootstrap(),
            new PropertyBootstrap(),
            new ProductBootstrap(),
            new PromotionBoostrap(),
            new OrderBootstrap(),
        ];
        foreach ($bootstrapper as $bootstrap) {
            $bootstrap->setInstallContext($context);
            $bootstrap->setContainer($this->container);
            $bootstrap->injectServices();
        }

        return $bootstrapper;
    }
}
