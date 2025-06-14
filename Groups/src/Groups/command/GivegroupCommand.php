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

class GivegroupCommand extends Command {

    public function __construct(){
        parent::__construct("givegroup", "", null, ["sg"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) return false;

        if (!isset($args[1])) {
            $sender->sendMessage(TextFormat::GREEN . "Usage: /givegroup <player> <group> <expiration on days>");
            return false;
        }

        $expirationOnSecond = 0;
        if (isset($args[2])) {
            $expirationOnSecond = ((((int) $args[2]) * 24 * 60 * 60) + time());
        }

        $groupName = $args[1];
        if (!in_array($groupName, Group::all())) {
            $sender->sendMessage(TextFormat::GREEN . "Group " . $groupName . " does NOT exist.");
            return false;
        }

        $player = Server::getInstance()->getPlayer($args[0]);
        if ($player instanceof Player) {
            $nickname = $player->getLowerCaseName();

            if (GroupHelper::getGroupValue($groupName) > GroupHelper::getGroupValue(PlayerDataFactory::getData($player->getLowerCaseName())->getGroupData()->getGroup())) {
                $sender->sendMessage(TextFormat::GREEN . "Added " . $nickname . " to the group successfully");

                \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `groups` (`nickname`, `group`, `expirationGroup`, `title`) VALUES("' . $nickname . '", "' . $groupName . '", "' . $expirationOnSecond . '", "' . Title::NONE . '") ON DUPLICATE KEY UPDATE `group` = "' . $groupName . '", `expirationGroup` = "' . $expirationOnSecond . '";');

                PlayerDataFactory::getData($player->getLowerCaseName())->getGroupData()->setGroup($groupName);

                GroupHelper::updateTags($player);
            } else {
                $sender->sendMessage(TextFormat::GREEN . "The player " . $nickname . " has great privilege");
            }
        } else {
            $nickname = strtolower($args[0]);

            \PlayerData\Loader::$mThread->pushQueryClosureInputPacket("SELECT `nickname`, `group` FROM `groups` WHERE `nickname` = '" . $nickname . "';",
                function (array $result) use ($nickname, $sender, $groupName, $expirationOnSecond) {
                    $groupNameUser = Group::NONE;
                    foreach ($result as $row) {
                        $groupNameUser = $row[1];
                    }

                    if (GroupHelper::getGroupValue($groupName) > GroupHelper::getGroupValue($groupNameUser)) {
                        $sender->sendMessage(TextFormat::GREEN . "Added " . $nickname . " to the group successfully");

                        \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `groups` (`nickname`, `group`, `expirationGroup`, `title`) VALUES("' . $nickname . '", "' . $groupName . '", "' . $expirationOnSecond . '", "' . Title::NONE . '") ON DUPLICATE KEY UPDATE `group` = "' . $groupName . '", `expirationGroup` = "' . $expirationOnSecond . '";');
                    } else {
                        $sender->sendMessage(TextFormat::GREEN . "The player " . $nickname . " has great privilege");
                    }
                }
            );
        }

        return true;
    }
}