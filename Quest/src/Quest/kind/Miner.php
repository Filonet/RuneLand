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

    /* ─────────────── Конструктор ─────────────── */

    public function __construct()
    {
        // Квест 1: Деревянная кирка
        $this->addQuest(0, 1, [
            ItemIds::WOODEN_PICKAXE => 1
        ], [
            ItemIds::WOODEN_PICKAXE => 1
        ], 120, 60);

        // Квест 2: 9 угля
        $this->addQuest(1, 2, [
            ItemIds::COAL => 9
        ], [], 180, 90);

        // Квест 3: 32 булыжника + 16 угля
        $this->addQuest(2, 3, [
            ItemIds::COBBLESTONE => 32,
            ItemIds::COAL => 16
        ], [], 240, 120);

        // Квест 4: 64 булыжника + 32 угля
        $this->addQuest(3, 4, [
            ItemIds::COBBLESTONE => 64,
            ItemIds::COAL => 32
        ], [], 300, 150);

        // Квест 5: Каменная кирка
        $this->addQuest(4, 5, [
            ItemIds::STONE_PICKAXE => 1
        ], [
            ItemIds::STONE_PICKAXE => 1
        ], 360, 180);

        // Квест 6: Железная руда + слитки + уголь
        $this->addQuest(5, 6, [
            ItemIds::IRON_ORE => 32,
            ItemIds::IRON_INGOT => 16,
            ItemIds::COAL => 64
        ], [], 450, 225);

        // Квест 7: Большая добыча железа
        $this->addQuest(6, 7, [
            ItemIds::IRON_INGOT => 64,
            ItemIds::STONE => 64,
            ItemIds::COAL => 32,
            ItemIds::IRON_ORE => 16,
            ItemIds::COBBLESTONE => 128
        ], [], 600, 300);

        // Квест 8: Отдых
        $this->addRestQuest(7, 8);

        // Квест 9: Железо и уголь
        $this->addQuest(8, 9, [
            ItemIds::IRON_INGOT => 64,
            ItemIds::IRON_ORE => 128,
            ItemIds::COAL => 128
        ], [], 750, 375);

        // Квест 10: Железная кирка
        $this->addQuest(9, 10, [
            ItemIds::IRON_PICKAXE => 1
        ], [
            ItemIds::IRON_PICKAXE => 1
        ], 900, 450);

        // Квест 11: Золото и драгоценности
        $this->addQuest(10, 11, [
            ItemIds::GOLD_ORE => 32,
            ItemIds::REDSTONE_DUST => 128,
            ItemIds::GOLD_INGOT => 64,
            ItemIds::DIAMOND => 2
        ], [], 1200, 600);

        // Квест 12: Большая коллекция драгоценностей
        $this->addQuest(11, 12, [
            ItemIds::DIAMOND => 15,
            ItemIds::GOLD_INGOT => 64,
            ItemIds::EMERALD => 2,
            ItemIds::DYE => 128,     // lapis lazuli
            ItemIds::REDSTONE_DUST => 128
        ], [], 1500, 750);

        // Квест 13: Зимние запасы
        $this->addQuest(12, 13, [
            ItemIds::COAL => 128,
            ItemIds::STONE => 128,
            ItemIds::EMERALD => 8,
            ItemIds::GOLD_INGOT => 64
        ], [], 1800, 900);

        // Квест 14: Алмазная кирка
        $this->addQuest(13, 14, [
            ItemIds::DIAMOND_PICKAXE => 1
        ], [
            ItemIds::DIAMOND_PICKAXE => 1
        ], 2200, 1100);

        // Квест 15: Испытание алмазной кирки
        $this->addQuest(14, 15, [
            ItemIds::COBBLESTONE => 256,
            ItemIds::IRON_ORE => 128,
            ItemIds::GOLD_ORE => 64
        ], [], 2600, 1300);

        // Квест 16: Много материалов
        $this->addQuest(15, 16, [
            ItemIds::IRON_INGOT => 128,
            ItemIds::DIAMOND => 32,
            ItemIds::COAL => 256
        ], [], 3000, 1500);

        // Квест 17: Отдых
        $this->addRestQuest(16, 17);

        // Квест 18: Редкие материалы
        $this->addQuest(17, 18, [
            ItemIds::EMERALD => 64,
            ItemIds::DYE => 128,          // lapis lazuli
            ItemIds::REDSTONE_DUST => 256
        ], [], 3500, 1750);

        // Квест 19: Большой заказ
        $this->addQuest(18, 19, [
            ItemIds::COBBLESTONE => 512,
            ItemIds::STONE => 256,
            ItemIds::IRON_INGOT => 128
        ], [], 4000, 2000);

        // Квест 20: Драгоценности
        $this->addQuest(19, 20, [
            ItemIds::DIAMOND => 128,
            ItemIds::EMERALD => 64,
            ItemIds::GOLD_BLOCK => 32
        ], [], 4500, 2250);

        // Квест 21: Отдых
        $this->addRestQuest(20, 21);

        // Квест 22: Массовая добыча
        $this->addQuest(21, 22, [
            ItemIds::IRON_INGOT => 256,
            ItemIds::GOLD_INGOT => 128,
            ItemIds::DIAMOND => 64
        ], [], 5000, 2500);

        // Квест 23: Экстремальная задача
        $this->addQuest(22, 23, [
            ItemIds::COAL => 512,
            ItemIds::IRON_ORE => 256,
            ItemIds::GOLD_ORE => 128
        ], [], 5500, 2750);

        // Квест 24: Предпоследнее испытание
        $this->addQuest(23, 24, [
            ItemIds::EMERALD => 128,
            ItemIds::DYE => 256,          // lapis lazuli
            ItemIds::REDSTONE_DUST => 512
        ], [], 6000, 3000);

        // Квест 25: Финальный вызов
        $this->addQuest(24, 25, [
            ItemIds::EMERALD => 256,
            ItemIds::DIAMOND => 256
        ], [], 10000, 5000);
    }

    /* ─────────────── Вспомогательные методы ─────────────── */

    /**
     * Добавляет обычный квест с требованиями.
     * 
     * @param int $questId ID квеста (начинается с 0)
     * @param int $questNumber Номер квеста для языковых строк (1-25)
     * @param array $requirements Требования [itemId => amount]
     * @param array $rewards Награды предметами [itemId => amount]
     * @param int $coins Награда монетами
     * @param int $exp Награда опытом
     */
    private function addQuest(int $questId, int $questNumber, array $requirements, array $rewards = [], int $coins = 0, int $exp = 0): void
    {
        $this->add($questId, new KindData(
            $this->makeTranslatedMessage("quest.miner.quest{$questNumber}.first"),
            $this->makeCheckHasItems($requirements),
            $this->makeRewardGiveItems($rewards, $coins, $exp, "quest.miner.quest{$questNumber}.second"),
            true
        ));
    }

    /**
     * Добавляет квест-отдых без требований.
     * 
     * @param int $questId ID квеста
     * @param int $questNumber Номер квеста для языковых строк
     */
    private function addRestQuest(int $questId, int $questNumber): void
    {
        $this->add($questId, new KindData(
            $this->makeTranslatedMessage("quest.miner.quest{$questNumber}.first"),
            $this->makeCheckAlwaysTrue(),
            $this->makeRewardGiveItems([], 0, 0, "quest.miner.quest{$questNumber}.second"),
            true
        ));
    }

    /**
     * Создаёт колбэк для отправки переведённого сообщения.
     */
    private function makeTranslatedMessage(string $langKey): callable
    {
        return fn(Player $p) => $p->sendMessage(Language::translate("%{$langKey}%", $p));
    }

    /**
     * Проверка: в инвентаре есть ВСЕ требуемые предметы/кол-ва с учётом damage values.
     * @param array $requirements Требования в формате [[itemId, damage] => amount] или [itemId => amount] для обратной совместимости
     */
    private function makeCheckHasItems(array $requirements): callable
    {
        return function (Player $p) use ($requirements): bool {
            // Собираем счётчики из инвентаря с учётом damage values
            $have = [];
            foreach ($p->getInventory()->getContents() as $stack) {
                $key = [$stack->getId(), $stack->getDamage()];
                $have[serialize($key)] = ($have[serialize($key)] ?? 0) + $stack->getCount();
            }

            // Ищем недостающие позиции
            $missing = [];
            foreach ($requirements as $itemKey => $need) {
                // Поддержка старого формата [itemId => amount] для обратной совместимости
                if (is_int($itemKey)) {
                    $serializedKey = serialize([$itemKey, 0]); // damage 0 по умолчанию
                    if (($have[$serializedKey] ?? 0) < $need) {
                        $item = ItemFactory::get($itemKey, 0);
                        $missing[] = $item->getName() . " ×" . ($need - ($have[$serializedKey] ?? 0));
                    }
                } else {
                    // Новый формат [[itemId, damage] => amount]
                    $serializedKey = serialize($itemKey);
                    if (($have[$serializedKey] ?? 0) < $need) {
                        [$itemId, $damage] = $itemKey;
                        $item = ItemFactory::get($itemId, $damage);
                        $missing[] = $item->getName() . " ×" . ($need - ($have[$serializedKey] ?? 0));
                    }
                }
            }

            if ($missing === []) {
                return true; // всё есть
            }

            $p->sendMessage("§cНе хватает: " . implode(', ', $missing));
            return false;
        };
    }

    /**
     * Проверка: всегда возвращает true (для квестов-отдыха).
     */
    private function makeCheckAlwaysTrue(): callable
    {
        return fn(Player $p): bool => true;
    }

    /**
     * Награда: опыт → деньги → предметы.
     *
     * @param array<int,int> $items  [itemId => amount]
     * @param int            $coins  Сколько монет начислить
     * @param int            $exp    Сколько опыта профессии дать
     * @param string         $langKey Ключ языкового сообщения игроку
     */
    private function makeRewardGiveItems(
        array $items = [],
        int $coins = 0,
        int $exp = 0,
        string $langKey = ''
    ): callable {
        return function (Player $p) use ($items, $coins, $exp, $langKey): void {
            // Добавляем опыт
            if ($exp > 0) {
                $playerData = PlayerDataFactory::getData($p->getLowerCaseName());
                $playerData->getJobData()->getMiner()->addExp($exp);
            }

            // Добавляем монеты
            if ($coins > 0) {
                $playerData = PlayerDataFactory::getData($p->getLowerCaseName());
                $playerData->getEconomyData()->addCoins($coins);
                $p->sendMessage("§a+{$coins} монет!");
            }

            // Добавляем предметы
            foreach ($items as $itemId => $amount) {
                $item = ItemFactory::get($itemId, 0, $amount);
                if ($p->getInventory()->canAddItem($item)) {
                    $p->getInventory()->addItem($item);
                } else {
                    $p->getLevel()->dropItem($p, $item);
                }
            }

            // Отправляем сообщение о завершении
            if (!empty($langKey)) {
                $p->sendMessage(Language::translate("%{$langKey}%", $p));
            }

            // Показываем полученный опыт
            if ($exp > 0) {
                $p->sendMessage("§b+{$exp} опыта шахтёра!");
            }
        };
    }
} 