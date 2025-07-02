<?php

declare(strict_types=1);

namespace API\task;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Level;
use pocketmine\scheduler\Task;

class SpeedTask extends Task {

    public function __construct(
        private Level $level
    ){}

    public function onRun(int $currentTick) : void {
        foreach ($this->level->getPlayers() as $player) {
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20 * 3, 5, false));

            if ($player->getFood() < $player->getMaxFood()) {
                $player->setFood($player->getMaxFood());
            }
        }
    }
}