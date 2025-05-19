<?php

declare(strict_types=1);

namespace Quest;

use pocketmine\plugin\PluginBase;
use Quest\command\QuestCommand;

class Loader extends PluginBase {
    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onEnable() : void{
        self::$instance = $this;

        $this->getServer()->getCommandMap()->register("quest", new QuestCommand());
    }
}