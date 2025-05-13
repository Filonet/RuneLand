<?php

declare(strict_types=1);

namespace API\command;

use API\manager\Manager;
use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class ClearCommand extends Command {

    /** @var bool[] */
    private array $accept = [];

    public function __construct(){
        parent::__construct("clear");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) {
            if (!isset($this->accept[$sender->getName()])) {
                $this->accept[$sender->getName()] = true;
                $sender->sendMessage(Language::translate("%api.command.clear.accept%", $sender));
            } else {
                unset($this->accept[$sender->getName()]);
                $sender->getInventory()->clearAll();
                $sender->sendMessage(Language::translate("%api.command.clear.success%", $sender, [
                    "nickname" => $sender->getName()
                ]));
            }
        }

        return true;
    }
}