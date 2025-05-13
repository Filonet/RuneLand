<?php

declare(strict_types=1);

namespace ScoreBoard;

use PlayerData\Language;
use pocketmine\plugin\PluginBase;
use ScoreBoard\listener\EventListener;
use ScoreBoard\manager\Manager;
use ScoreBoard\task\UpdateTask;

class Loader extends PluginBase {

    private Manager $manager;

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "ScoreBoard" . DIRECTORY_SEPARATOR . "lang");

        $this->manager = new Manager();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this, $this->manager), $this);

        $this->getScheduler()->scheduleRepeatingTask(new UpdateTask($this, $this->manager), 40);
    }

    public function getManager() : Manager {
        return $this->manager;
    }
}