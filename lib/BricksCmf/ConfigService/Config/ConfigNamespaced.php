<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService\Config;

use BricksFramework\Config\ConfigInterface;

class ConfigNamespaced implements ConfigInterface, ConfigNamespacedInterface
{
    /** @var ConfigInterface */
    protected $config;

    protected $namespaces = [];

    public function __construct(ConfigInterface $config, array $namespaces = []) {
        $this->config = $config;
        $this->namespaces = $namespaces;
    }

    public function get(string $path)
    {
        $value = null;
        foreach ($this->getNamespaces() as $namespace) {
            $value = $this->config->get($namespace . $path) ?: $value;
        }
        return $value;
    }

    public function set(string $path, $value): void
    {
        $this->config->set($path, $value);
    }

    public function remove(string $path): void
    {
        $this->config->remove($path);
    }

    public function has(string $path): bool
    {
        foreach ($this->getNamespaces() as $namespace) {
            if ($this->config->has($namespace . $path)) {
                return true;
            }
        }
        return false;
    }

    public function merge(array $data)
    {
        $this->config->merge($data);
    }

    public function setNamespaces(array $namespaces) : void
    {
        $this->namespaces = $namespaces;
    }

    public function getNamespaces() : array
    {
        return array_merge(['', 'default'], $this->namespaces);
    }
}
