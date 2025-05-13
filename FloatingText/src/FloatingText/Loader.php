<?php

declare(strict_types=1);

namespace FloatingText;

use FloatingText\listener\EventListener;
use PlayerData\Language;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "FloatingText" . DIRECTORY_SEPARATOR . "lang");

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}