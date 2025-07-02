<?php

declare(strict_types=1);

namespace Kits;

use Kits\command\KitCommand;
use Kits\listener\EventListener;
use Kits\manager\Manager;
use PlayerData\Language;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Kits" . DIRECTORY_SEPARATOR . "lang");

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        $manager = new Manager($this->getServer()->getDefaultLevel());
        $manager->spawnShulkers();

        $this->getServer()->getCommandMap()->register("kits", new KitCommand($manager));
    }
}