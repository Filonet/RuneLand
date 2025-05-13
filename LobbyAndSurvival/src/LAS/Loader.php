<?php

declare(strict_types=1);

namespace LAS;

use LAS\listener\EventListener;
use LAS\task\UnderTeleportTask;
use PlayerData\Language;
use pocketmine\level\GameRules;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {
    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "LAS" . DIRECTORY_SEPARATOR . "lang");

        $this->getServer()->loadLevel("survival");

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

        $this->getScheduler()->scheduleRepeatingTask(new UnderTeleportTask($this), 5);

        $survivalLevel = $this->getServer()->getLevelByName("survival");
        $survivalLevel->getGameRules()->setBool(GameRules::RULE_DO_MOB_SPAWNING, true);

        $survivalLevel = $this->getServer()->getDefaultLevel();
        $survivalLevel->getGameRules()->setBool(GameRules::RULE_DO_MOB_SPAWNING, false);
    }
}