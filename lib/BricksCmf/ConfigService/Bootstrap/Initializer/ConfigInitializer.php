<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService\Bootstrap\Initializer;

use BricksCmf\ConfigService\ConfigService;
use BricksCmf\EventizrService\EventizrService;
use BricksCmf\EventManager\EventManager;
use BricksCmf\LazyLoaderService\LazyLoaderService;
use BricksFramework\Bootstrap\BootstrapInterface;
use BricksFramework\Bootstrap\Initializer\AbstractInitializer;

class ConfigInitializer extends AbstractInitializer
{
    public function initialize(BootstrapInterface $bootstrap): void
    {
        if (in_array(ConfigService::SERVICE_NAME, $bootstrap->getServices())) {
            return;
        }

        $eventizrService = $bootstrap->getService(EventizrService::SERVICE_NAME);
        $lazyloaderService = $bootstrap->getService(LazyLoaderService::SERVICE_NAME);
        $eventManager = $bootstrap->getService(EventManager::SERVICE_NAME);

        if ($eventizrService) {
            $eventizrService->eventize('BricksFramework\\Config\\Config');
        }

        $arrayKeyParser = $bootstrap->getInstance('BricksFramework\\ArrayKeyParser\\ArrayKeyParser');

        if ($lazyloaderService) {
            $config = $lazyloaderService->get('BricksCompile\\Eventizr\\BricksFramework\\Config\\Config', [
                $arrayKeyParser,
                $eventManager
            ]);
        } else {
            $config = $bootstrap->getInstance('BricksFramework\\Config\\Config', [
                'arrayKeyParser' => $arrayKeyParser
            ]);
        }

        $namespaces = [$bootstrap->getEnvironment()->getCurrentEnvironment()];

        $configService = $bootstrap->getInstance('BricksCmf\\ConfigService\\ConfigService', [
            $config,
            $namespaces
        ]);

        $bootstrap->setService(ConfigService::SERVICE_NAME, $configService);
    }

    public function getPriority(): int
    {
        return -9500;
    }
}
