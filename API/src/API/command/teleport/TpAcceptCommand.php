<?php

declare(strict_types=1);

namespace API\command\teleport;

use API\manager\Manager;
use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class TpAcceptCommand extends Command {
    public function __construct(
        private Manager $manager
    ){
        parent::__construct('tpaccept', 'tpaccept', '/tpaccept', ['tpc']);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        $nickname = $sender->getLowerCaseName();
        $tpSenders = TpaCommand::$tpSenders[$nickname] ?? [];
        foreach ($tpSenders as $playerNickName => $boolean) {
            $target = $sender->getServer()->getPlayer($playerNickName);

            unset(TpaCommand::$tpSenders[$nickname][$playerNickName]);
            if ($target instanceof Player) {
                $sender->sendMessage(Language::translate("%api.command.tpAccept.success.target%", $sender, ["player" => $target->getName()]));
                $target->sendMessage(Language::translate("%api.command.tpAccept.success.player%", $target, ["target" => $sender->getName()]));

                $this->manager->teleport($target, $sender, 3, $sender->getLowerCaseName());
                return true;
            }
        }

        $sender->sendMessage(Language::translate("%api.command.tpAccept.notFound%", $sender));

        return true;
    }

}