<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksFramework\Config\Event\Config;

use BricksFramework\Event\Event;

class FilterVariables
{
    public function filter(Event $event)
    {
        $config = $event->getTarget();
        $return = $event->getReturn();

        if (preg_match_all('#{{(.*?)}}#', $return, $matches)) {
            foreach ($matches[1] as $match) {
                preg_replace('#{{.*?}}#', $config->get($matches[1]), $return);
            }
        }

        $event->addReturn($return);
    }
}
