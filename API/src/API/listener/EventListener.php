<?php

declare(strict_types=1);

namespace API\listener;

use API\manager\Manager;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
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
}