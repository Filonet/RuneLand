<?php

declare(strict_types=1);

namespace Kits\command;

use API\utils\Utils;
use Groups\types\Permission;
use Kits\manager\Manager;
use Kits\types\Settings;
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
            $giveKitId = null;
            $cooldown = 0;
            foreach (Settings::KITS2 as $kitId => $kitData) {
                $cooldown = time() + $kitData["cooldown"];

                if (!isset($kitData["permission"])) {
                    $giveKitId = $kitId;
                    continue;
                }

                if (Permission::hasPermission($sender, $kitData["permission"])) {
                    $giveKitId = $kitId;
                    break;
                }
            }

            if ($giveKitId === null || $cooldown === null) {
                return false;
            }

            $sessionTime = $sender->namedtag->getInt("sessionTime", 0);
            if ($sessionTime > time()) {
                $sender->sendMessage(Language::translate("%kits.wait.cooldown%", $sender, [
                    "time" => Utils::getFormattedTime($sessionTime - time(), $sender)
                ]));
                return true;
            }

            $this->manager->giveKit($sender, $giveKitId);
            $sender->namedtag->setInt("sessionTime", $cooldown);
        }
        return true;
    }
}