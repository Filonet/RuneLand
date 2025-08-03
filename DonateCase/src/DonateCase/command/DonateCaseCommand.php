<?php

declare(strict_types=1);

namespace DonateCase\command;

use API\utils\Utils;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;

class DonateCaseCommand extends Command {

    public function __construct(){
        parent::__construct("donatecase", "donatecase", "/donatecase", ["dc"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) {
            $count = PlayerDataFactory::getData($sender->getLowerCaseName())->getDonateCases();
            $sender->sendMessage("Ваш баланс §7- §d" . Utils::declensionOf($count, ["%d ключ", "%d ключа", "%d ключей"]));
            return false;
        } elseif ($sender instanceof ConsoleCommandSender and isset($args[0])) {
            if (strtolower($args[0]) == "add") {
                if (!isset($args[2])) {
                    $sender->sendMessage("Использование §7- §d/megacase add <name> <count>");
                    return false;
                }

                $target = $sender->getServer()->getPlayer($args[1]);
                if ($target === null) {
                    $nickname = strtolower($args[1]);
                } else {
                    $nickname = $target->getLowerCaseName();
                }

                $count = (int)$args[2];

                $sender->sendMessage("Вы успешно выдали ключи игроку §d" . $nickname);

                PlayerDataFactory::getData($nickname)->setDonateCases(PlayerDataFactory::getData($nickname)->getDonateCases() + $count);

                Loader::$mThread->pushQueryPacket('INSERT INTO `donatecase` (`nickname`, `count`) VALUES("' . $nickname . '", "' . $count . '") ON DUPLICATE KEY UPDATE `count` = `count` + "' . $count . '";');
            }
        }

        return true;
    }

}