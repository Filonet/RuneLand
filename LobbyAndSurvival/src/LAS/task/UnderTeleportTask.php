<?php

declare(strict_types=1);

namespace LAS\task;

use API\Loader as APILoader;
use LAS\Loader;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

class UnderTeleportTask extends Task {
    private Level $lobbyLevel;

    public function __construct(Loader $loader){
        $this->lobbyLevel = $loader->getServer()->getDefaultLevel(); //мир лобби
    }

    public function onRun(int $currentTick) : void{
        foreach ($this->lobbyLevel->getPlayers() as $player) {
            if ($this->isZone($player)) {
                APILoader::getInstance()->getManager()->randomTeleport($player);
            }
        }
    }

    private function isZone(Vector3 $position) : bool{
        if(
            //($position->x >= 331 and $position->x <= 341) and
            //($position->y >= 65 and $position->y <= 65) and
            //($position->z >= 308 and $position->z <= 318)

            $position->y <= 20
        ){
            return true;
        }
        return false;
    }
}