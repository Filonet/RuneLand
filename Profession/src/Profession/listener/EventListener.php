<?php

declare(strict_types=1);

namespace Profession\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use Profession\data\ProfessionFactory;

class EventListener implements Listener {

    public function onBreak(BlockBreakEvent $event): void{
        if (!$event->getPlayer()->isSurvival()) return;

        foreach (ProfessionFactory::getAll() as $profession) {
            $profession->onBlockBreak($event);
        }
    }

    public function onPlace(BlockPlaceEvent $event): void{
        if (!$event->getPlayer()->isSurvival()) return;

        foreach (ProfessionFactory::getAll() as $profession) {
            $profession->onBlockPlace($event);
        }
    }
}