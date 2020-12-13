<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService;

use BricksCmf\ConfigService\Config\ConfigNamespacedInterface;

interface ConfigServiceInterface
{
    public function getConfig(array $namespaces = []) : ConfigNamespacedInterface;
}
