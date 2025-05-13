<?php

declare(strict_types=1);

namespace ScoreBoard\task;

use pocketmine\scheduler\Task;
use ScoreBoard\Loader;
use ScoreBoard\manager\Manager;

class UpdateTask extends Task {

    public function __construct(
        public Loader $loader,
        public Manager $manager
    ){}

    public function onRun(int $currentTick) : void{
        $players = $this->loader->getServer()->getOnlinePlayers();
        if(count($players) === 0){
            return;
        }

        foreach($players as $player){
            $this->manager->update($player);
        }
    }

}