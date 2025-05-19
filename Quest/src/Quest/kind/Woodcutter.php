<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\data\PlayerDataFactory;
use PlayerData\types\StaticQuestData;
use pocketmine\item\Axe;
use pocketmine\item\Sword;
use pocketmine\Player;
use Quest\types\Settings;

class Woodcutter extends Kind {
    public function __construct() {
        $this->add(0, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Здравствуй! Я вижу ты новенький. Для начала сделай себе топор!");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand instanceof Axe) {
                    return true;
                }

                $player->sendMessage("Здравствуй ещё раз! Для начала сделай себе топор!");
                return false;
            },
            null,
            true
        ));

        $this->add(1, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Хорошо. А теперь принеси мне (10 дуба), и получишь награду. ");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand instanceof Sword) {
                    return true;
                }

                $player->sendMessage("Принеси мне (10 дуба), и получишь награду.");
                return false;
            },
            null, //выдача награды
            true
        ));
    }

    public function getQuestData(Player $player) : StaticQuestData {
        return PlayerDataFactory::getData($player->getLowerCaseName())->getQuestData()->getWoodcutter();
    }
}