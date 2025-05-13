<?php

declare(strict_types=1);

namespace API\command\teleport;

use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class TpaCancelCommand extends Command {
    public function __construct(){
        parent::__construct('tpacancel', 'tpacancel', '/tpacancel');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        $count = 0;
        foreach (TpaCommand::$tpSenders as $target => $targets) {
            foreach ($targets as $player => $bool) {
                if ($player === $sender->getLowerCaseName()) {
                    $count++;
                    unset(TpaCommand::$tpSenders[$target][$player]);
                }
            }
        }

        if ($count === 0) {
            $sender->sendMessage(Language::translate("%api.command.tpaCancel.notFound%", $sender));
            return false;
        }

        $sender->sendMessage(Language::translate("%api.command.tpaCancel.success%", $sender));
        return true;
    }
}