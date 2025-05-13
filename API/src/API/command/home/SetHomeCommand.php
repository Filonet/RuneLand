<?php

declare(strict_types=1);

namespace API\command\teleport;

use Groups\types\Permission;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use PlayerData\Loader;
use PlayerData\types\TeleportDataHome;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class SetHomeCommand extends Command {
    public function __construct(){
        parent::__construct("sethome", "sethome", "/sethome <name>");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        if (isset($args[0])) {
            if (preg_match("/^[a-zA-Z0-9]+$/", $args[0])) {
                $homes = PlayerDataFactory::getData($sender->getLowerCaseName())->getTeleportData()->getHomes();
                if (count($homes) > 0) {
                    $maxHomes = match (true) {
                        default => 4,
                    };
                    if (count($homes) >= $maxHomes) {
                        $sender->sendMessage(Language::translate("%api.command.setHome.busy%", $sender, ["maxHomes" => $maxHomes]));
                        return false;
                    }
                    if (isset($homes[$args[0]])) {
                        $sender->sendMessage(Language::translate("%api.command.setHome.busy%", $sender));
                        return false;
                    }
                }

                if ($sender->getServer()->getDefaultLevel()->getFolderName() === $sender->getLevel()->getFolderName()) {
                    $sender->sendMessage(Language::translate("%api.command.setHome.intersects%", $sender));
                    return false;
                }

                $x = $sender->getFloorX();
                $y = $sender->getFloorY();
                $z = $sender->getFloorZ();

                $homes[$args[0]] = new TeleportDataHome($args[0], $x, $y, $z);
                PlayerDataFactory::getData($sender->getLowerCaseName())->getTeleportData()->setHomes($homes);

                $homesEncodeArray = [];
                foreach ($homes as $home) {
                    $homesEncodeArray[$home->getName()] = [$home->getX(), $home->getY(), $home->getZ()];
                }

                $homesEncode = json_encode($homesEncodeArray);
                Loader::$mThread->pushQueryPacket("INSERT INTO `teleport` (`nickname`, `homes`) VALUES('" . $sender->getLowerCaseName() . "', '" . $homesEncode . "') ON DUPLICATE KEY UPDATE `homes` = '" . $homesEncode . "';");

                $sender->sendMessage(Language::translate("%api.command.setHome.success%", $sender));
            } else {
                $sender->sendMessage(Language::translate("%api.command.setHome.bad.name%", $sender));
            }
        } else {
            $sender->sendMessage(Language::translate("%api.command.setHome.usage%", $sender));
        }

        return true;
    }

}