<?php

declare(strict_types=1);

namespace PlayerData;

use PlayerData\data\PlayerData;
use PlayerData\data\PlayerDataFactory;
use PlayerData\event\LoadPlayerDataEvent;
use PlayerData\listener\EventListener;
use PlayerData\mysql\MySQLManager;
use PlayerData\mysql\MysqlThread;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;

class Loader extends PluginBase implements Listener {

    public static MysqlThread $mThread;

    public function onEnable() : void{
        MySQLManager::init();

        Language::loadFromPath($this->getFile() . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "PlayerData" . DIRECTORY_SEPARATOR . "lang");

        (self::$mThread = new MysqlThread($this->getServer()->getPort()))->start(\pmmp\thread\Thread::INHERIT_NONE);

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function (int $currentTick) : void {
            $this->checkMysqlThread();

            $this->checkMysqlClosureThread();
        }), 1);
    }

    public function checkMysqlThread() : void{
        while (($entry = self::$mThread->readDataResultPacket()) !== false && $entry !== NULL) {
            if (is_string($entry)) var_dump(igbinary_unserialize($entry));
            foreach ($entry as $name => $data) {
                $player = $this->getServer()->getPlayerExact((string) $name);

                /** @var $data PlayerData */
                if ($player === null or $player->getClientId() !== $data->getCid()) {
                    continue;
                }

                PlayerDataFactory::setData($player->getLowerCaseName(), $data);
                (new LoadPlayerDataEvent($player, $data))->call();
            }
        }
    }

    public function checkMysqlClosureThread() : void{
        while (($entry = self::$mThread->readQueryClosureOutputPacket()) !== false && $entry !== NULL) {
            if (is_string($entry)) var_dump(igbinary_unserialize($entry));
            [$result, $closure] = $entry;

            $closure($result);
        }
    }
}