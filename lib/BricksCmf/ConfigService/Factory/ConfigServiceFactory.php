<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService\Factory;

use BricksCmf\ConfigService\Config\ConfigNamespaced;
use BricksCmf\ConfigService\Config\ConfigNamespacedInterface;
use BricksCmf\ConfigService\ConfigService;
use BricksFramework\ArrayKeyParser\ArrayKeyParser;
use BricksFramework\Bootstrap\BootstrapInterface;
use BricksFramework\Config\Config;
use BricksFramework\Container\PsrContainer;
use BricksFramework\Factory\Factory;

class ConfigServiceFactory extends Factory
{
    public function get(PsrContainer $container, string $class, array $arguments = []): object
    {
        $config = $this->getConfig($container, $arguments);

        // we load via bootstrap getInstance because this belongs to a very basically service
        if ($container->has('bricks/bootstrap')) {
            /** @var BootstrapInterface $bootstrap */
            $bootstrap = $container->get('bricks/bootstrap');
            $configService = $bootstrap->getInstance($class, [
                $config
            ]);
        } else {
            $configService = new $class($config);
        }

        return $configService;
    }

    protected function getConfig(PsrContainer $container, array $arguments = []) : ConfigNamespacedInterface
    {
        $configNamespaced = $arguments['config'] ?? false;
        if (!$configNamespaced) {
            if ($container->has('bricks/bootstrap')) {
                $bootstrap = $container->get('bricks/bootstrap');
                $arrayKeyParser = $bootstrap->getInstance('BricksFramework\\ArrayKeyParser\\ArrayKeyParser');
                $config = $bootstrap->getInstance('BricksFramework\\Config\\Config', [
                    'arrayKeyParser' => $arrayKeyParser
                ]);
                $configService = $bootstrap->getInstance('BricksCmf\\ConfigService\\ConfigService', [
                    'config' => $config
                ]);
            } else {
                $arrayKeyParser = new ArrayKeyParser();
                $config = new Config($arrayKeyParser);
                $configService = new ConfigService($config);
            }
            $configNamespaced = $configService->getConfig();
        }
        return $configNamespaced;
    }
}