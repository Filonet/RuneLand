<?php

declare(strict_types=1);

namespace Quest\manager;

use PlayerData\data\PlayerDataFactory;
use pocketmine\Player;

class Manager {
    public function __construct() {
        //NOOP
    }

    public function find(Player $player) : void {
        $questData = PlayerDataFactory::getData($player->getLowerCaseName())->getQuestData();
        $questId = $questData->getQuestId();
        if ($questId === -1) {


        }
    }

}