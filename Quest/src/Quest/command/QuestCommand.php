<?php

declare(strict_types=1);

namespace Quest\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class QuestCommand extends Command {

    public function __construct(){
        parent::__construct("quest");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{

        return true;
    }
}