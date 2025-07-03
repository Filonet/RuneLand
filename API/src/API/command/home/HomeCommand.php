<?php

declare(strict_types=1);

namespace API\command\home;

use API\manager\Manager;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;

class HomeCommand extends Command {
    public function __construct(
        private Manager $manager
    ){
        parent::__construct("home", "home", "/home");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$sender instanceof Player) return false;

        $homes = PlayerDataFactory::getData($sender->getLowerCaseName())->getTeleportData()->getHomes();

        if (isset($args[0])) {
            if (isset($homes[$args[0]])) {
                $coords = $homes[$args[0]];

                $x = $coords->getX();
                $y = $coords->getY();
                $z = $coords->getZ();

                $this->manager->teleport($sender, new Position($x, $y, $z, $sender->getServer()->getLevelByName("survival")), 3, (string) $coords->getName());
                return false;
            }
        }

        $list = [];
        foreach ($homes as $name => $coords) {
            $list[] = $name;
        }

        $sender->sendMessage(Language::translate("%api.command.home.list%", $sender, ["list" => implode(", ", $list)]));

        return true;
    }

}