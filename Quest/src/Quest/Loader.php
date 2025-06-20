<?php

declare(strict_types=1);

namespace Quest;

use NPC\Loader as NPCLoader;
use PlayerData\Language;
use pocketmine\entity\Skin;
use pocketmine\level\Location;
use pocketmine\plugin\PluginBase;
use Quest\command\QuestCommand;
use Quest\kind\KindFactory;

class Loader extends PluginBase {
    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Quest" . DIRECTORY_SEPARATOR . "lang");

        self::$instance = $this;

        $this->getServer()->getCommandMap()->register("quest", new QuestCommand());

        KindFactory::getInstance()->spawnHumans($this->getServer()->getDefaultLevel());
    }
}