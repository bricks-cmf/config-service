<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksFramework\Config\Event\Config;

use BricksFramework\Event\Event;
use BricksFramework\Cache\CacheInterface;

class LoadFromCache
{
    /** @var CacheInterface */
    protected $cache;

    protected function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function load(Event $event)
    {
        $config = $event->getTarget();
        $configData = $this->cache->get('service.bricks-config.cached-config-data') ?: [];
        $config->merge($configData);
    }
}
