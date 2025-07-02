<?php

declare(strict_types=1);

namespace Kits\command;

use API\utils\Utils;
use Groups\types\Permission;
use Kits\manager\Manager;
use Kits\types\Settings;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class KitCommand extends Command {

    public function __construct(
        private Manager $manager
    ){
        parent::__construct("kit");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
        if ($sender instanceof Player) {
            $senderGroup = PlayerDataFactory::getData($sender->getLowerCaseName())->getGroupData()->getGroup();
            if (!isset(Settings::KITS[$senderGroup])) {
                return false;
            }

            $cooldown = Settings::KITS[$senderGroup]["cooldown"];

            $sessionTime = $sender->namedtag->getInt("kitCooldown", 0);
            if ($sessionTime > time()) {
                $sender->sendMessage(Language::translate("%kits.wait.cooldown%", $sender, [
                    "time" => Utils::getFormattedTime($sessionTime - time(), $sender)
                ]));
                return true;
            }

            $this->manager->giveKit($sender, $senderGroup);
            $sender->namedtag->setInt("kitCooldown", $cooldown);
        }
        return true;
    }
}