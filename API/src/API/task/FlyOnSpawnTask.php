<?php

declare(strict_types=1);

namespace API\task;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Level;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class FlyOnSpawnTask extends Task {

    public function __construct(
        private Level $level
    ){}

    public function onRun(int $currentTick) : void {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if ($player->getLevel() !== $this->level) {
                $player->setAllowFlight(false);
            } else {
                $player->setAllowFlight(true);

                if ($player->getFood() < $player->getMaxFood()) {
                    $player->setFood($player->getMaxFood());
                }
            }
        }
    }
}