<?php

declare(strict_types=1);

namespace API\command;

use API\manager\Manager;
use API\utils\Utils;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class StatsCommand extends Command {
    public function __construct(
        private Manager $manager
    ){
        parent::__construct("stats", "stats", "/stats");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) {
            $data = PlayerDataFactory::getData($sender->getLowerCaseName())->getStatsData();

            $sender->sendMessage("\n");
            $sender->sendMessage("  " . $sender->getDisplayName());
            $sender->sendMessage("  §7⚔ §a" . $data->getKills() . " §7☠ §a" . $data->getDeaths());
            $sender->sendMessage("  §f" . Language::translate("%api.command.stats.wellPlayed%", $sender) . ": §c" . Utils::getFormattedTime($this->manager->getGameTime($sender), $sender));
            $sender->sendMessage("\n");
        }

        return true;
    }
}