<?php

declare(strict_types=1);

namespace Groups;

use Groups\command\GivegroupCommand;
use Groups\command\GroupsCommand;
use Groups\command\SetgroupCommand;
use Groups\listener\EventListener;
use Groups\task\CheckTimeGroupTask;
use PlayerData\Language;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    private static self $instance;

    public static function getInstance() : self{
        return self::$instance;
    }

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Groups" . DIRECTORY_SEPARATOR . "lang");

        self::$instance = $this;

        $this->getServer()->getCommandMap()->registerAll("groups", [
            new GivegroupCommand(),
            new GroupsCommand(),
            new SetgroupCommand()
        ]);

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        $this->getScheduler()->scheduleRepeatingTask(new CheckTimeGroupTask($this->getServer()), 20 * 5);
    }
}