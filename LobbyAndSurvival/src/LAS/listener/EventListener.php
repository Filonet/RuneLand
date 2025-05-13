<?php

declare(strict_types=1);

namespace LAS\listener;

use PlayerData\Language;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use LAS\Loader;
use pocketmine\Player;

class EventListener implements Listener {
    private string $lobbyLevelName;

    public function __construct(Loader $loader){
        $this->lobbyLevelName = $loader->getServer()->getDefaultLevel()->getFolderName(); //мир лобби
    }

    public function onBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();
        if($player->getLevel()->getFolderName() === $this->lobbyLevelName and !$player->isOp()){
            $event->setCancelled();
            $player->sendMessage(Language::translate("%las.no.permission.break%", $player));
        }
    }

    public function onPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        if($player->getLevel()->getFolderName() === $this->lobbyLevelName and !$player->isOp()){
            $event->setCancelled();
            $player->sendMessage(Language::translate("%las.no.permission.place%", $player));
        }
    }

    public function onDamage(EntityDamageEvent $event): void {
        if ($event instanceof EntityDamageByEntityEvent) {
            $player = $event->getDamager();
            if ($player instanceof Player) {
                if ($player->getLevel()->getFolderName() === $this->lobbyLevelName and !$player->isOp()) {
                    $event->setCancelled();
                    $player->sendMessage(Language::translate("%las.no.permission.pvp%", $player));
                }
            }
        }
    }
}