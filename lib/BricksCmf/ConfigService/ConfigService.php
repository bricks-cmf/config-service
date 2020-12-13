<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService;

use BricksCmf\ConfigService\Config\ConfigNamespaced;
use BricksCmf\ConfigService\Config\ConfigNamespacedInterface;
use BricksFramework\Config\ConfigInterface;

class ConfigService implements ConfigServiceInterface
{
    const SERVICE_NAME = 'bricks/config';

    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getConfig(array $namespaces = []) : ConfigNamespacedInterface
    {
        return new ConfigNamespaced($this->config, $namespaces);
    }
}
