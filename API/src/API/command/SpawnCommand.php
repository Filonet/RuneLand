<?php

declare(strict_types=1);

namespace API\command;

use API\manager\Manager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SpawnCommand extends Command {

    public function __construct(
        private Manager $manager
    ){
        parent::__construct("spawn");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) {
            $this->manager->teleport($sender, $sender->getServer()->getDefaultLevel()->getSafeSpawn(), 3);
        }

        return true;
    }
}