<?php

declare(strict_types=1);

namespace NPC\entity;

use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class CustomHuman extends Human {

    protected ?\Closure $onUse = null;

    public function __construct(Level $level, CompoundTag $nbt, ?\Closure $onUse = null){
        parent::__construct($level, $nbt);
        $this->onUse = $onUse;
    }

    public function saveNBT(): void{}

    public function attack(EntityDamageEvent $source): void{
        $source->setCancelled();
        if ($source instanceof EntityDamageByEntityEvent) {
            $damager = $source->getDamager();
            if ($damager instanceof Player) {
                if ($this->onUse !== null) {
                    ($this->onUse)($damager);
                }
            }
        }
    }
}