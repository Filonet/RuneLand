<?php

declare(strict_types=1);

namespace DonateCase;

use DonateCase\command\DonateCaseCommand;
use DonateCase\listener\EventListener;
use PlayerData\Language;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "DonateCase" . DIRECTORY_SEPARATOR . "lang");

        $this->getServer()->getCommandMap()->register("donatecase", new DonateCaseCommand());
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}