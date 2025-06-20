<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\data\PlayerDataFactory;
use PlayerData\types\StaticQuestData;
use pocketmine\block\BlockIds;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Woodcutter extends Kind {

    public function getQuestData(Player $player) : StaticQuestData {
        return PlayerDataFactory::getData($player->getLowerCaseName())->getQuestData()->getWoodcutter();
    }

    public function getNameTag() : string {
        return "Woodcutter"; //translator use
    }

    public function getVector3(): Vector3{
        return new Vector3(200.5, 119, 173.5);
    }

    public function getYaw(): float{
        return 0;
    }

    public function getPitch(): float{
        return 0;
    }

    public function getSkinName() : string{
        return "lumberjack";
    }

    public function __construct() {
        $this->add(0, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Здравствуй! Я вижу ты новенький. Для начала сделай себе топор! [Сделай деревянный топор и вернись к дровосеку]");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand->getId() === ItemIds::WOODEN_AXE) {
                    return true;
                }

                $player->sendMessage("Здравствуй ещё раз! Для начала сделай себе топор! [Сделай деревянный топор и вернись к дровосеку]");
                return false;
            },
            function (Player $player) : void {
                //награды
            },
            true
        ));

        $this->add(1, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Хорошо. А теперь принеси мне (10 дуба), и получишь награду. [Принеси Дворосеку (10 дуба)]");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand->getId() === BlockIds::LOG && $itemInHand->getCount() >= 10) {
                    $player->getInventory()->removeItem((clone $itemInHand)->setCount(10));
                    return true;
                }

                $player->sendMessage("Принеси мне (10 дуба), и получишь награду. [Принеси Дворосеку (10 дуба)].");
                return false;
            },
            null, //выдача награды
            true
        ));

        $this->add(2, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Спасибо. Дальше мне надо (32 дубовые доски). [Принеси дровосеку 32 дубовые доски]");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand->getId() === BlockIds::PLANKS && $itemInHand->getCount() >= 32) {
                    $player->getInventory()->removeItem((clone $itemInHand)->setCount(32));
                    return true;
                }

                $player->sendMessage("Принеси мне (32 дубовые доски), и получишь награду. [Принеси дровосеку 32 дубовые доски]");
                return false;
            },
            null, //выдача награды
            true
        ));

        $this->add(3, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Неплохо. Не пора бы тебе улучшить свой топор? [Сделай каменный топор и вернись к дровосеку]");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand->getId() === ItemIds::STONE_AXE) {
                    return true;
                }

                $player->sendMessage("Здравствуй ещё раз! Улучши себе топор! [Сделай каменный топор и вернись к дровосеку]");
                return false;
            },
            null, //выдача награды
            true
        ));

        $this->add(4, new KindData(
            function (Player $player) : void {
                $player->sendMessage("Отлично! Теперь ты можешь добывать больше видов деревьев. [Принеси дровосеку 32 дуба]");
            },
            function (Player $player) : bool {
                $itemInHand = $player->getInventory()->getItemInHand();
                if ($itemInHand->getId() === BlockIds::LOG && $itemInHand->getCount() >= 32) {
                    $player->getInventory()->removeItem((clone $itemInHand)->setCount(32));
                    return true;
                }

                $player->sendMessage("Отлично! Теперь ты можешь добывать больше видов деревьев. [Принеси дровосеку 32 дуба]");
                return false;
            },
            null, //выдача награды
            true
        ));
    }
}