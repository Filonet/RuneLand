<?php

declare(strict_types=1);

namespace Quest\kind;

use API\Loader;
use API\manager\Manager;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use PlayerData\types\StaticQuestData;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\Player;

/**
 * NPC-квест «Шахтёр».
 * 
 * Полная цепочка из 25 квестов для шахтёра.
 */
class Miner extends Kind
{
    /* ─────────────── NPC-метаданные ─────────────── */

    public function getQuestData(Player $player): StaticQuestData
    {
        return PlayerDataFactory::getData($player->getLowerCaseName())
            ->getQuestData()
            ->getMiner();
    }

    public function getNameTag(): string   { return 'Miner'; }
    public function getVector3(): Vector3  { return new Vector3(210.5, 119, 180.5); }
    public function getYaw(): float        { return 180; }
    public function getPitch(): float      { return 0; }
    public function getSkinName(): string  { return 'miner'; }
    public function getLanguageKey() : string { return 'miner'; }

    public function __construct(){
        // Квест 1: Деревянная кирка
        $this->addQuest(0, 1, [
            ItemIds::WOODEN_PICKAXE . ':0' => 1
        ], [
            ItemIds::WOODEN_PICKAXE . ':0' => 1
        ], 120, 60);

        // Квест 2: 9 угля
        $this->addQuest(1, 2, [
            ItemIds::COAL . ':0' => 9
        ], [], 180, 90);

        // Квест 3: 32 булыжника + 16 угля
        $this->addQuest(2, 3, [
            ItemIds::COBBLESTONE . ':0' => 32,
            ItemIds::COAL . ':0' => 16
        ], [], 240, 120);

        // Квест 4: 64 булыжника + 32 угля
        $this->addQuest(3, 4, [
            ItemIds::COBBLESTONE . ':0' => 64,
            ItemIds::COAL . ':0' => 32
        ], [], 300, 150);

        // Квест 5: Каменная кирка
        $this->addQuest(4, 5, [
            ItemIds::STONE_PICKAXE . ':0' => 1
        ], [
            ItemIds::STONE_PICKAXE . ':0' => 1
        ], 360, 180);

        // Квест 6: Железная руда + слитки + уголь
        $this->addQuest(5, 6, [
            ItemIds::IRON_ORE . ':0' => 32,
            ItemIds::IRON_INGOT . ':0' => 16,
            ItemIds::COAL . ':0' => 64
        ], [], 450, 225);

        // Квест 7: Большая добыча железа
        $this->addQuest(6, 7, [
            ItemIds::IRON_INGOT . ':0' => 64,
            ItemIds::STONE . ':0' => 64,
            ItemIds::COAL . ':0' => 32,
            ItemIds::IRON_ORE . ':0' => 16,
            ItemIds::COBBLESTONE . ':0' => 128
        ], [], 600, 300);

        // Квест 8: Отдых
        $this->addRestQuest(7, 8);

        // Квест 9: Железо и уголь
        $this->addQuest(8, 9, [
            ItemIds::IRON_INGOT . ':0' => 64,
            ItemIds::IRON_ORE . ':0' => 128,
            ItemIds::COAL . ':0' => 128
        ], [], 750, 375);

        // Квест 10: Железная кирка
        $this->addQuest(9, 10, [
            ItemIds::IRON_PICKAXE . ':0' => 1
        ], [
            ItemIds::IRON_PICKAXE . ':0' => 1
        ], 900, 450);

        // Квест 11: Золото и драгоценности
        $this->addQuest(10, 11, [
            ItemIds::GOLD_ORE . ':0' => 32,
            ItemIds::REDSTONE_DUST . ':0' => 128,
            ItemIds::GOLD_INGOT . ':0' => 64,
            ItemIds::DIAMOND . ':0' => 2
        ], [], 1200, 600);

        // Квест 12: Большая коллекция драгоценностей
        $this->addQuest(11, 12, [
            ItemIds::DIAMOND . ':0' => 15,
            ItemIds::GOLD_INGOT . ':0' => 64,
            ItemIds::EMERALD . ':0' => 2,
            ItemIds::DYE . ':0'=> 128,     // lapis lazuli
            ItemIds::REDSTONE_DUST . ':0' => 128
        ], [], 1500, 750);

        // Квест 13: Зимние запасы
        $this->addQuest(12, 13, [
            ItemIds::COAL . ':0' => 128,
            ItemIds::STONE . ':0' => 128,
            ItemIds::EMERALD . ':0' => 8,
            ItemIds::GOLD_INGOT . ':0' => 64
        ], [], 1800, 900);

        // Квест 14: Алмазная кирка
        $this->addQuest(13, 14, [
            ItemIds::DIAMOND_PICKAXE . ':0' => 1
        ], [
            ItemIds::DIAMOND_PICKAXE . ':0' => 1
        ], 2200, 1100);

        // Квест 15: Испытание алмазной кирки
        $this->addQuest(14, 15, [
            ItemIds::COBBLESTONE . ':0' => 256,
            ItemIds::IRON_ORE . ':0' => 128,
            ItemIds::GOLD_ORE . ':0' => 64
        ], [], 2600, 1300);

        // Квест 16: Много материалов
        $this->addQuest(15, 16, [
            ItemIds::IRON_INGOT . ':0' => 128,
            ItemIds::DIAMOND . ':0' => 32,
            ItemIds::COAL . ':0' => 256
        ], [], 3000, 1500);

        // Квест 17: Отдых
        $this->addRestQuest(16, 17);

        // Квест 18: Редкие материалы
        $this->addQuest(17, 18, [
            ItemIds::EMERALD . ':0' => 64,
            ItemIds::DYE . ':0' => 128,          // lapis lazuli
            ItemIds::REDSTONE_DUST . ':0' => 256
        ], [], 3500, 1750);

        // Квест 19: Большой заказ
        $this->addQuest(18, 19, [
            ItemIds::COBBLESTONE . ':0' => 512,
            ItemIds::STONE . ':0' => 256,
            ItemIds::IRON_INGOT . ':0' => 128
        ], [], 4000, 2000);

        // Квест 20: Драгоценности
        $this->addQuest(19, 20, [
            ItemIds::DIAMOND . ':0' => 128,
            ItemIds::EMERALD . ':0' => 64,
            ItemIds::GOLD_BLOCK . ':0' => 32
        ], [], 4500, 2250);

        // Квест 21: Отдых
        $this->addRestQuest(20, 21);

        // Квест 22: Массовая добыча
        $this->addQuest(21, 22, [
            ItemIds::IRON_INGOT . ':0' => 256,
            ItemIds::GOLD_INGOT . ':0' => 128,
            ItemIds::DIAMOND . ':0' => 64
        ], [], 5000, 2500);

        // Квест 23: Экстремальная задача
        $this->addQuest(22, 23, [
            ItemIds::COAL . ':0' => 512,
            ItemIds::IRON_ORE . ':0' => 256,
            ItemIds::GOLD_ORE . ':0' => 128
        ], [], 5500, 2750);

        // Квест 24: Предпоследнее испытание
        $this->addQuest(23, 24, [
            ItemIds::EMERALD . ':0' => 128,
            ItemIds::DYE . ':0' => 256,          // lapis lazuli
            ItemIds::REDSTONE_DUST . ':0' => 512
        ], [], 6000, 3000);

        // Квест 25: Финальный вызов
        $this->addQuest(24, 25, [
            ItemIds::EMERALD . ':0' => 256,
            ItemIds::DIAMOND . ':0' => 256
        ], [], 10000, 5000);
    }
} 