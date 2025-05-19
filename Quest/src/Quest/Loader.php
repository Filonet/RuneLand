<?php

declare(strict_types=1);

namespace Quest;

use PlayerData\Language;
use pocketmine\plugin\PluginBase;
use Quest\command\QuestCommand;

class Loader extends PluginBase {
    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Quest" . DIRECTORY_SEPARATOR . "lang");

        self::$instance = $this;

        $this->getServer()->getCommandMap()->register("quest", new QuestCommand());
    }
}