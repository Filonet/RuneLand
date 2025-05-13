<?php

declare(strict_types=1);

namespace API\command\home;

use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use PlayerData\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class DelHomeCommand extends Command {
    public function __construct(){
        parent::__construct("delhome", "delhome", "/delhome");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        $homes = PlayerDataFactory::getData($sender->getLowerCaseName())->getTeleportData()->getHomes();
        if (isset($args[0])) {
            if (!isset($homes[$args[0]])) {
                $sender->sendMessage(Language::translate("%api.command.delHome.dont.found%", $sender));
                return false;
            }

            unset($homes[$args[0]]);
            PlayerDataFactory::getData($sender->getLowerCaseName())->getTeleportData()->setHomes($homes);

            $homesEncodeArray = [];
            foreach ($homes as $home) {
                $homesEncodeArray[$home->getName()] = [$home->getX(), $home->getY(), $home->getZ()];
            }

            $homesEncode = json_encode($homesEncodeArray);
            Loader::$mThread->pushQueryPacket("INSERT INTO `teleport` (`nickname`, `homes`) VALUES('" . $sender->getLowerCaseName() . "', '" . $homesEncode . "') ON DUPLICATE KEY UPDATE `homes` = '" . $homesEncode . "';");

            $sender->sendMessage(Language::translate("%api.command.delHome.success%", $sender, ["home" => $args[0]]));
        } else {
            $sender->sendMessage(Language::translate("%api.command.delHome.usage%", $sender));
        }

       return true;
    }

}