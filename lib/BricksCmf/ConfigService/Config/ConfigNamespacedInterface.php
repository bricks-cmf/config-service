<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\ConfigService\Config;

interface ConfigNamespacedInterface
{
    public function getNamespaces() : array;
    public function setNamespaces(array $namespaces) : void;
}
