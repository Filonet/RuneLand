<?php

declare(strict_types=1);

namespace NPC;

use NPC\entity\CustomHuman;
use NPC\manager\Manager;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    private static self $instance;

    public static function getInstance() : self {
        return self::$instance;
    }

    private Manager $manager;

    public function onEnable(): void{
        self::$instance = $this;

        Entity::registerEntity(CustomHuman::class);

        $this->manager = new Manager();
    }

    public function getManager() : Manager{
        return $this->manager;
    }
}