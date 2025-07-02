<?php

declare(strict_types=1);

namespace Profession;

use PlayerData\Language;
use pocketmine\plugin\PluginBase;
use Profession\data\ProfessionFactory;
use Profession\listener\EventListener;

class Loader extends PluginBase {

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Profession" . DIRECTORY_SEPARATOR . "lang");

        ProfessionFactory::init();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}