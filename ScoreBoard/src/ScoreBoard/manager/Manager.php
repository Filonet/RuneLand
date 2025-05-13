<?php

declare(strict_types=1);

namespace ScoreBoard\manager;

use PlayerData\data\PlayerDataFactory;
use PlayerData\helper\PlayerDataHelper;
use PlayerData\Language;
use PlayerData\types\Group;
use pocketmine\Player;
use ScoreBoard\utils\ScoreboardFormat;

class Manager {
    public function __construct(){
        //NOOP
    }

    public function spawnTo(Player $player, string $title, string|array $lines, array $replacements = []) : void {
        $title = Language::translate($title, $player, $replacements);
        if (is_string($lines)) {
            $lines = explode("\n", Language::translate($lines, $player, $replacements));
        }

        $lines = array_map(fn(string $text) => Language::translate($text, $player, $replacements), $lines);
        ScoreboardFormat::sendScoreboard($player, $title, $lines);
    }

    public function update(Player $player) : void {
        $nickname = $player->getLowerCaseName();

        //TODO: создать систему кеширования текста, чтобы одинаковый текст не отправлялся повторно

        $playerDataHelper = PlayerDataHelper::getInstance();
        $data = PlayerDataFactory::getData($nickname);
        $statsData = $data->getStatsData();
        $this->spawnTo($player, "%scoreboard.update.title%", "%scoreboard.update.lines%", [
            "nickname" => $player->getName(),
            "group" => $data->getGroupName() === Group::NONE ? "%scoreboard.dont.group%" : $data->getGroupName(),
            "title" => $data->getTitleName() === Group::NONE ? "%scoreboard.dont.title%" : $data->getTitleName(),
            "kills" => $statsData->getKills(),
            "deaths" => $statsData->getDeaths(),
            "ping" => $player->getPing(),
            "runes" => $playerDataHelper->getRunes($nickname),
            "money" => $playerDataHelper->getMoney($nickname)
        ]);
    }
}