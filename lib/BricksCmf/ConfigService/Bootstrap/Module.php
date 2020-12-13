<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService\Bootstrap;

use BricksFramework\Bootstrap\BootstrapInterface;
use BricksFramework\Bootstrap\Module\AbstractModule;
use BricksCmf\ConfigService\Bootstrap\Initializer\ConfigInitializer;

class Module extends AbstractModule
{
    public function getInitializerClasses(): array
    {
        return [
            ConfigInitializer::class
        ];
    }
}
