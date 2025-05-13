<?php

declare(strict_types=1);

namespace ScoreBoard\listener;

use PlayerData\event\LoadPlayerDataEvent;
use pocketmine\event\Listener;
use pocketmine\scheduler\ClosureTask;
use ScoreBoard\Loader;
use ScoreBoard\manager\Manager;

class EventListener implements Listener {
    public function __construct(
        private Loader $loader,
        private Manager $manager
    ){}

    public function onLoad(LoadPlayerDataEvent $event) : void {
        $player = $event->getPlayer();
        $this->loader->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($player): void {
            $this->manager->update($player);
        }), 10);
    }
}