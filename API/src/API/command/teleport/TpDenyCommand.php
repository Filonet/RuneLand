<?php

declare(strict_types=1);

namespace API\command\teleport;

use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class TpDenyCommand extends Command {
    public function __construct(){
        parent::__construct('tpdeny', 'tpdeny', '/tpdeny', ['tpd']);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        $nickname = $sender->getLowerCaseName();
        $tpSenders = TpaCommand::$tpSenders[$nickname] ?? [];
        foreach ($tpSenders as $playerNickName => $boolean) {
            $target = $sender->getServer()->getPlayer($playerNickName);
            if ($target instanceof Player) {
                $sender->sendMessage(Language::translate("%api.command.tpDeny.success%", $sender, ["target" => $target->getName()]));

                unset(TpaCommand::$tpSenders[$nickname][$playerNickName]);
                return true;
            } else {
                unset(TpaCommand::$tpSenders[$nickname][$playerNickName]);
            }
        }

        $sender->sendMessage(Language::translate("%api.command.tpDeny.notFound%", $sender));
        return true;
    }
}