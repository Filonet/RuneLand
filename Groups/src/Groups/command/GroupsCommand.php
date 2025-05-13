<?php

declare(strict_types=1);

namespace Groups\command;

use PlayerData\types\Group;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class GroupsCommand extends Command {

    public function __construct(){
        parent::__construct("groups");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) return false;

        $sender->sendMessage(TextFormat::GREEN . "All registered groups: " . implode(", ", Group::all()));
        return true;
    }
}