<?php

declare(strict_types=1);

namespace Groups\command;

use Groups\helper\GroupHelper;
use Groups\Loader;
use PlayerData\data\PlayerDataFactory;
use PlayerData\types\Group;
use PlayerData\types\Title;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class SetgroupCommand extends Command {

    public function __construct(){
        parent::__construct("setgroup");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) return false;

        if (!isset($args[1])) {
            $sender->sendMessage(TextFormat::GREEN . "Usage: /setgroup <player> <group>");
            return false;
        }

        $player = Server::getInstance()->getPlayer($args[0]);
        if ($player instanceof Player) {
            $nickname = $player->getLowerCaseName();
        } else {
            $nickname = strtolower($args[0]);
        }

        $groupName = $args[1];
        if (!in_array($groupName, Group::all())) {
            $sender->sendMessage(TextFormat::GREEN . "Group " . $groupName . " does NOT exist.");
            return false;
        }

        $sender->sendMessage(TextFormat::GREEN . "Added " . $nickname . " to the group successfully");

        \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `groups` (`nickname`, `group`, `title`) VALUES("' . $nickname . '", "' . $groupName . '", "' . Title::NONE . '") ON DUPLICATE KEY UPDATE `group` = "' . $groupName . '";');

        if ($player instanceof Player) {
            PlayerDataFactory::getData($player->getLowerCaseName())->setGroupName($groupName);

            GroupHelper::updateTags($player);
        }

        return true;
    }
}