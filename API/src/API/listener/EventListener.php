<?php

declare(strict_types=1);

namespace API\listener;

use API\Loader;
use API\manager\Manager;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;

class EventListener implements Listener {
    public function __construct(
        private Manager $manager
    ){}

    public function onMove(PlayerMoveEvent $event) : void {
        $player = $event->getPlayer();

        $this->manager->cancelTeleport($player);
    }

    public function onDamage(EntityDamageEvent $event) : void {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
            if ($this->manager->isRandomTeleport($entity)) {
                $event->setCancelled();
            }
        }
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        Loader::$playerTimes[$player->getLowerCaseName()] = time();
    }

    public function onQuit(PlayerQuitEvent $event) : void{
        $player = $event->getPlayer();

        if (isset(Loader::$playerTimes[$player->getLowerCaseName()])) {
            $time = (time() - Loader::$playerTimes[$player->getLowerCaseName()]);
            \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `stats` (`nickname`, `money`, `runes`, `kills`, `deaths`, `gameTime`) VALUES("' . $player->getLowerCaseName() . '", 0, 0, 0, 0, ' . $time . ') ON DUPLICATE KEY UPDATE `gameTime` = `gameTime` + ' . $time . ';');

            unset(Loader::$playerTimes[$player->getLowerCaseName()]);
        }
    }
}