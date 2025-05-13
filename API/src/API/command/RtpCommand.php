<?php

declare(strict_types=1);

namespace API\command;

use API\manager\Manager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class RtpCommand extends Command {
    public function __construct(
        private Manager $manager
    ){
        parent::__construct("rtp");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) {
            $this->manager->randomTeleport($sender);
        }

        return true;
    }
}