<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\data\PlayerDataFactory;
use PlayerData\types\StaticQuestData;
use pocketmine\Player;
use Quest\types\Settings;

class Woodcutter extends Kind {
    public function __construct() {
        $this->add(0, new KindData(Settings::TYPE_DATA_PASS_ITEMS, "Здравствуй! Я вижу ты новенький. Для начала сделай себе топор!",
            function (Player $player) : bool {
                var_dump(1);
                //проверяет, есть ли необходимое вещи (прогресс?)
                return false;
            },
            function (Player $player) : void {
                var_dump(21);
                //есть все успешно, то работает
            }
        ));
    }

    public function getQuestData(Player $player) : StaticQuestData {
        return PlayerDataFactory::getData($player->getLowerCaseName())->getQuestData()->getWoodcutter();
    }
}