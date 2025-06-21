<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use PlayerData\types\StaticQuestData;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\Player;

/**
 * Охотник - NPC, который даёт квесты на получение дропов от неразмножаемых мобов.
 * 25 квестов от начинающего охотника до мастера охоты.
 */
class Hunter extends Kind
{
    public function getQuestData(Player $player): StaticQuestData
    {
        return PlayerDataFactory::getData($player->getLowerCaseName())->getQuestData()->getHunter();
    }

    public function getNameTag(): string   { return 'Hunter'; }
    public function getVector3(): Vector3  { return new Vector3(175.5, 119, 180.5); }
    public function getYaw(): float        { return 225; }
    public function getPitch(): float      { return 0; }
    public function getSkinName(): string  { return 'hunter'; }

    /* ─────────────── Конструктор с квестами ─────────────── */

    public function __construct()
    {
        // Квест 1: Первые трофеи
        $this->addQuest(0, 1, [
            ItemIds::ROTTEN_FLESH . ':0' => 8  // ID 367, damage 0
        ], [], 140, 70);

        // Квест 2: Костная мука
        $this->addQuest(1, 2, [
            ItemIds::BONE . ':0' => 6  // ID 352, damage 0
        ], [], 160, 80);

        // Квест 3: Паучьи сети
        $this->addQuest(2, 3, [
            ItemIds::STRING . ':0' => 12  // ID 287, damage 0
        ], [], 180, 90);

        // Квест 4: Взрывчатка
        $this->addQuest(3, 4, [
            ItemIds::GUNPOWDER . ':0' => 10  // ID 289, damage 0
        ], [], 220, 110);

        // Квест 5: Глаза хищника
        $this->addQuest(4, 5, [
            ItemIds::SPIDER_EYE . ':0' => 8  // ID 375, damage 0
        ], [], 250, 125);

        // Квест 6: Липкая слизь
        $this->addQuest(5, 6, [
            ItemIds::SLIMEBALL . ':0' => 5  // ID 341, damage 0
        ], [], 280, 140);

        // Квест 7: Чернила для письма
        $this->addQuest(6, 7, [
            ItemIds::DYE . ':0' => 10  // ID 351, damage 0 (чернила)
        ], [], 320, 160);

        // Квест 8: Отдых - изучение повадок
        $this->addRestQuest(7, 8);

        // Квест 9: Ночная охота
        $this->addQuest(8, 9, [
            ItemIds::ROTTEN_FLESH . ':0' => 20,  // зомби
            ItemIds::BONE . ':0' => 15,          // скелеты
            ItemIds::STRING . ':0' => 18         // пауки
        ], [], 400, 200);

        // Квест 10: Взрывоопасный груз
        $this->addQuest(9, 10, [
            ItemIds::GUNPOWDER . ':0' => 24
        ], [], 480, 240);

        // Квест 11: Алхимические компоненты
        $this->addQuest(10, 11, [
            ItemIds::SPIDER_EYE . ':0' => 16,
            ItemIds::SLIMEBALL . ':0' => 12,
            ItemIds::GUNPOWDER . ':0' => 20
        ], [], 600, 300);

        // Квест 12: Эндер жемчужина
        $this->addQuest(11, 12, [
            ItemIds::ENDER_PEARL . ':0' => 3  // ID 368, damage 0
        ], [], 800, 400);

        // Квест 13: Огненный стержень
        $this->addQuest(12, 13, [
            ItemIds::BLAZE_ROD . ':0' => 2  // ID 369, damage 0
        ], [], 1000, 500);

        // Квест 14: Слёзы гаста
        $this->addQuest(13, 14, [
            ItemIds::GHAST_TEAR . ':0' => 1  // ID 370, damage 0
        ], [], 1200, 600);

        // Квест 15: Магматический крем
        $this->addQuest(14, 15, [
            ItemIds::MAGMA_CREAM . ':0' => 4  // ID 378, damage 0
        ], [], 1000, 500);

        // Квест 16: Портальное путешествие
        $this->addQuest(15, 16, [
            ItemIds::ENDER_PEARL . ':0' => 8,
            ItemIds::BLAZE_ROD . ':0' => 4,
            ItemIds::GHAST_TEAR . ':0' => 2
        ], [], 1600, 800);

        // Квест 17: Отдых - улучшение снаряжения
        $this->addRestQuest(16, 17);

        // Квест 18: Массовая охота
        $this->addQuest(17, 18, [
            ItemIds::ROTTEN_FLESH . ':0' => 64,
            ItemIds::BONE . ':0' => 48,
            ItemIds::STRING . ':0' => 40,
            ItemIds::GUNPOWDER . ':0' => 32
        ], [], 1800, 900);

        // Квест 19: Редкие трофеи
        $this->addQuest(18, 19, [
            ItemIds::SPIDER_EYE . ':0' => 32,
            ItemIds::SLIMEBALL . ':0' => 24,
            ItemIds::DYE . ':0' => 32  // чернила
        ], [], 2000, 1000);

        // Квест 20: Эндер коллекция
        $this->addQuest(19, 20, [
            ItemIds::ENDER_PEARL . ':0' => 16
        ], [], 2400, 1200);

        // Квест 21: Отдых - древние знания
        $this->addRestQuest(20, 21);

        // Квест 22: Адские материалы
        $this->addQuest(21, 22, [
            ItemIds::BLAZE_ROD . ':0' => 8,
            ItemIds::GHAST_TEAR . ':0' => 4,
            ItemIds::MAGMA_CREAM . ':0' => 12
        ], [], 2800, 1400);

        // Квест 23: Алхимический склад
        $this->addQuest(22, 23, [
            ItemIds::SPIDER_EYE . ':0' => 64,
            ItemIds::GUNPOWDER . ':0' => 64,
            ItemIds::SLIMEBALL . ':0' => 48
        ], [], 3200, 1600);

        // Квест 24: Мастер порталов
        $this->addQuest(23, 24, [
            ItemIds::ENDER_PEARL . ':0' => 32,
            ItemIds::BLAZE_ROD . ':0' => 16,
            ItemIds::GHAST_TEAR . ':0' => 8
        ], [], 4000, 2000);

        // Квест 25: Легендарный охотник
        $this->addQuest(24, 25, [
            ItemIds::ROTTEN_FLESH . ':0' => 128,
            ItemIds::BONE . ':0' => 96,
            ItemIds::STRING . ':0' => 80,
            ItemIds::GUNPOWDER . ':0' => 64,
            ItemIds::SPIDER_EYE . ':0' => 48,
            ItemIds::ENDER_PEARL . ':0' => 24,
            ItemIds::BLAZE_ROD . ':0' => 12,
            ItemIds::GHAST_TEAR . ':0' => 6
        ], [], 6000, 3000);
    }

    /* ─────────────── Вспомогательные методы ─────────────── */

    /**
     * Добавляет обычный квест с требованиями.
     * 
     * @param int $questId ID квеста (начинается с 0)
     * @param int $questNumber Номер квеста для языковых строк (1-25)
     * @param array $requirements Требования ['itemId:damage' => amount]
     * @param array $rewards Награды предметами ['itemId:damage' => amount]
     * @param int $coins Награда монетами
     * @param int $exp Награда опытом
     */
    private function addQuest(int $questId, int $questNumber, array $requirements, array $rewards = [], int $coins = 0, int $exp = 0): void
    {
        $this->add($questId, new KindData(
            $this->makeTranslatedMessage("quest.hunter.quest{$questNumber}.first"),
            $this->makeCheckHasItems($requirements),
            $this->makeRewardGiveItems($rewards, $coins, $exp, "quest.hunter.quest{$questNumber}.second"),
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
            $this->makeTranslatedMessage("quest.hunter.quest{$questNumber}.first"),
            $this->makeCheckAlwaysTrue(),
            $this->makeRewardGiveItems([], 0, 0, "quest.hunter.quest{$questNumber}.second"),
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
     * @param array $requirements Требования в формате ['itemId:damage' => amount]
     */
    private function makeCheckHasItems(array $requirements): callable
    {
        return function (Player $p) use ($requirements): bool {
            // Собираем счётчики из инвентаря с учётом damage values
            $have = [];
            foreach ($p->getInventory()->getContents() as $stack) {
                $key = $stack->getId() . ':' . $stack->getDamage();
                $have[$key] = ($have[$key] ?? 0) + $stack->getCount();
            }

            // Ищем недостающие позиции
            $missing = [];
            foreach ($requirements as $itemKey => $need) {
                if (($have[$itemKey] ?? 0) < $need) {
                    [$itemId, $damage] = explode(':', $itemKey);
                    $item = ItemFactory::get((int)$itemId, (int)$damage);
                    $missing[] = $item->getName() . " ×" . ($need - ($have[$itemKey] ?? 0));
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
     * @param array $items  Предметы в формате ['itemId:damage' => amount]
     * @param int   $coins  Сколько монет начислить
     * @param int   $exp    Сколько опыта профессии дать
     * @param string $langKey Ключ языкового сообщения игроку
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
                $playerData->getJobData()->getHunter()->addExp($exp);
            }

            // Добавляем монеты
            if ($coins > 0) {
                $playerData = PlayerDataFactory::getData($p->getLowerCaseName());
                $playerData->getEconomyData()->addCoins($coins);
                $p->sendMessage("§a+{$coins} монет!");
            }

            // Добавляем предметы
            foreach ($items as $itemKey => $amount) {
                [$itemId, $damage] = explode(':', $itemKey);
                $item = ItemFactory::get((int)$itemId, (int)$damage, $amount);
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
                $p->sendMessage("§b+{$exp} опыта охотника!");
            }
        };
    }
} 