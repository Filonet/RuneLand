<?php

declare(strict_types=1);

namespace API;

use API\command\ClearCommand;
use API\command\home\DelHomeCommand;
use API\command\home\HomeCommand;
use API\command\RtpCommand;
use API\command\SpawnCommand;
use API\command\teleport\SetHomeCommand;
use API\command\teleport\TpaCancelCommand;
use API\command\teleport\TpAcceptCommand;
use API\command\teleport\TpaCommand;
use API\command\teleport\TpDenyCommand;
use API\listener\EventListener;
use API\manager\Manager;
use PlayerData\Language;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {
    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    private Manager $manager;

    public function onEnable() : void{
        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "API" . DIRECTORY_SEPARATOR . "lang");

        self::$instance = $this;

        $this->manager = new Manager($this);

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this->manager), $this);

        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->unregister($commandMap->getCommand("clear"));
        $commandMap->registerAll("api", [
            new SpawnCommand($this->manager),
            new ClearCommand(),
            new RtpCommand($this->manager),

            new TpaCommand(),
            new TpDenyCommand(),
            new TpaCancelCommand(),
            new TpAcceptCommand($this->manager),

            new SetHomeCommand(),
            new DelHomeCommand(),
            new HomeCommand($this->manager),
        ]);
    }

    public function getManager() : Manager{
        return $this->manager;
    }
}