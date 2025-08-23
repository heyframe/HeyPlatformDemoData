<?php declare(strict_types=1);

use HeyFrame\Core\TestBootstrapper;

$loader = (new TestBootstrapper())
    ->addCallingPlugin()
    ->addActivePlugins('HeyPlatformDemoData')
    ->setForceInstallPlugins(true)
    ->bootstrap()
    ->getClassLoader();

$loader->addPsr4('Hey\\PlatformDemoData\\Tests\\', __DIR__);
