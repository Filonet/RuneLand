<?php

declare(strict_types=1);

namespace API\command\teleport;

use API\Loader;
use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;

class TpaCommand extends Command {
    /** @var string[][]  */
    public static array $tpSenders = [];

    public function __construct(){
        parent::__construct('tpa', 'tpa', '/tpa', ['call']);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        if(!isset($args[0])){
            $sender->sendMessage(Language::translate("%api.command.tpa.usage%", $sender));
            return false;
        }

        $target = $sender->getServer()->getPlayer($args[0]);
        if ($target instanceof Player) {
            if (trim(strtolower($sender->getName())) == trim(strtolower($target->getName()))) {
                $sender->sendMessage(Language::translate("%api.command.tpa.usage%", $sender));
                return true;
            }

            if (isset(self::$tpSenders[$target->getLowerCaseName()][$sender->getLowerCaseName()])) {
                $sender->sendMessage(Language::translate("%api.command.tpa.already%", $sender, ["target" => $target->getName()]));
                return false;
            }

            self::$tpSenders[$target->getLowerCaseName()][$sender->getLowerCaseName()] = true;

            $sender->sendMessage(Language::translate("%api.command.tpa.success.player%", $sender, ["target" => $target->getName()]));
            $target->sendMessage(Language::translate("%api.command.tpa.success.target%", $target, ["player" => $sender->getName()]));

            Loader::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($target, $sender) : void{
                unset(self::$tpSenders[$target->getLowerCaseName()][$sender->getLowerCaseName()]);
            }), 20*60);
        } else {
            $sender->sendMessage(Language::translate("%api.command.tpa.notFound%", $sender));
        }

        return true;
    }

}