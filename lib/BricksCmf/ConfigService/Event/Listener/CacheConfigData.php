<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksFramework\Config\Event\Config;

use BricksFramework\Cache\CacheInterface;
use BricksFramework\ArrayKeyParser\ArrayKeyParser;
use BricksFramework\Config\ConfigInterface;
use BricksFramework\Event\Event;

class CacheConfigData
{
    /** @var CacheInterface */
    protected $cache;

    /** @var ConfigInterface */
    protected $config;

    protected $configData = [];

    protected $hasConfigChanged = false;

    public function __construct(CacheInterface $cache, ConfigInterface $config)
    {
        $this->cache = $cache;
        $this->config = $config;
    }

    public function cache(Event $event)
    {
        if (!$this->isConfigServiceCacheEnabled()) {
            return;
        }

        $config = $event->getTarget();
        $params = $event->getParams();
        $path = $params['path'];

        $this->configData = $this->cache->get('service.bricks-config.cached-config-data') ?: [];
        $arrayKeyParser = new ArrayKeyParser();

        $value = $config->get($path);
        if ($arrayKeyParser->get($this->configData, $path) !== $value) {
            $arrayKeyParser->set($this->configData, $path, $value);
            $this->hasConfigChanged = true;
        }
    }

    public function __destruct()
    {
        if ($this->hasConfigChanged || !$this->isConfigServiceCacheEnabled()) {
            return;
        }
        $this->cache->set('service.bricks-config.cache-config-data', $configData);
    }

    protected function isConfigServiceCacheEnabled()
    {
        $cacheEnabled = $this->config->get('bricks-cache.enabled') ?: false;
        $configCacheEnabled = $this->config->get('bricks-config.service-cache.enabled') ?: false;
        return $cacheEnabled && $configCacheEnabled;
    }
}
