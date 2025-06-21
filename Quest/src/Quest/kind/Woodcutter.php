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
 * NPC-квест «Дровосек».
 * 
 * Полная цепочка из 25 квестов для дровосека.
 */
class Woodcutter extends Kind
{
    /* ─────────────── NPC-метаданные ─────────────── */

    public function getQuestData(Player $player): StaticQuestData
    {
        return PlayerDataFactory::getData($player->getLowerCaseName())
            ->getQuestData()
            ->getWoodcutter();
    }

    public function getNameTag(): string   { return 'Woodcutter'; }
    public function getVector3(): Vector3  { return new Vector3(200.5, 119, 173.5); }
    public function getYaw(): float        { return 0; }
    public function getPitch(): float      { return 0; }
    public function getSkinName(): string  { return 'lumberjack'; }

    /* ─────────────── Конструктор ─────────────── */

    public function __construct()
    {
        // Квест 1: Дубовая палочка
        $this->addQuest(0, 1, [
            ItemIds::STICK . ':0' => 1  // ID 280, damage 0
        ], [], 100, 50);

        // Квест 2: 10 дубовых брёвен
        $this->addQuest(1, 2, [
            ItemIds::LOG . ':0' => 10  // ID 17, damage 0 (дуб)
        ], [], 150, 75);

        // Квест 3: 32 дубовых брёвен
        $this->addQuest(2, 3, [
            ItemIds::LOG . ':0' => 32  // ID 17, damage 0 (дуб)
        ], [], 200, 100);

        // Квест 4: 32 дубовых досок
        $this->addQuest(3, 4, [
            ItemIds::PLANKS . ':0' => 32  // ID 5, damage 0 (дуб)
        ], [], 250, 125);

        // Квест 5: 64 дубовых брёвен
        $this->addQuest(4, 5, [
            ItemIds::LOG . ':0' => 64  // ID 17, damage 0 (дуб)
        ], [], 300, 150);

        // Квест 6: Отдых
        $this->addRestQuest(5, 6);

        // Квест 7: 64 дубовых досок
        $this->addQuest(6, 7, [
            ItemIds::PLANKS . ':0' => 64  // ID 5, damage 0 (дуб)
        ], [], 400, 200);

        // Квест 8: 128 дубовых брёвен
        $this->addQuest(7, 8, [
            ItemIds::LOG . ':0' => 128  // ID 17, damage 0 (дуб)
        ], [], 500, 250);

        // Квест 9: Отдых
        $this->addRestQuest(8, 9);

        // Квест 10: 32 берёзовых + 32 тёмного дуба
        $this->addQuest(9, 10, [
            ItemIds::LOG2 . ':0' => 32,  // ID 162, damage 0 (берёза)
            ItemIds::LOG2 . ':1' => 32   // ID 162, damage 1 (тёмный дуб)
        ], [], 600, 300);

        // Квест 11: 64 берёзовых + 64 тёмного дуба
        $this->addQuest(10, 11, [
            ItemIds::LOG2 . ':0' => 64,  // ID 162, damage 0 (берёза)
            ItemIds::LOG2 . ':1' => 64   // ID 162, damage 1 (тёмный дуб)
        ], [], 700, 350);

        // Квест 12: 64 акации
        $this->addQuest(11, 12, [
            ItemIds::LOG2 . ':2' => 64  // ID 162, damage 2 (акация)
        ], [], 750, 375);

        // Квест 13: Смешанная древесина
        $this->addQuest(12, 13, [
            ItemIds::LOG2 . ':0' => 64,  // ID 162, damage 0 (берёза)
            ItemIds::LOG2 . ':1' => 64,  // ID 162, damage 1 (тёмный дуб)
            ItemIds::LOG2 . ':2' => 64   // ID 162, damage 2 (акация)
        ], [], 800, 400);

        // Квест 14: Отдых
        $this->addRestQuest(13, 14);

        // Квест 15: Доски: 128 дубовых, 192 берёзовых, 64 тёмного дуба
        $this->addQuest(14, 15, [
            ItemIds::PLANKS . ':0' => 128,  // ID 5, damage 0 (дуб)
            ItemIds::PLANKS . ':2' => 192,  // ID 5, damage 2 (берёза)
            ItemIds::PLANKS . ':5' => 64    // ID 5, damage 5 (тёмный дуб)
        ], [], 1000, 500);

        // Квест 16: 64 акации, 128 тёмного дуба, 256 дубовых досок
        $this->addQuest(15, 16, [
            ItemIds::LOG2 . ':2' => 64,     // ID 162, damage 2 (акация)
            ItemIds::LOG2 . ':1' => 128,    // ID 162, damage 1 (тёмный дуб)
            ItemIds::PLANKS . ':0' => 256   // ID 5, damage 0 (дуб)
        ], [], 1200, 600);

        // Квест 17: 384 дубовых плит, 64 акации, 128 тёмного дуба
        $this->addQuest(16, 17, [
            ItemIds::WOODEN_SLAB . ':0' => 384,  // ID 158, damage 0 (дубовые плиты)
            ItemIds::LOG2 . ':2' => 64,          // ID 162, damage 2 (акация)
            ItemIds::LOG2 . ':1' => 128          // ID 162, damage 1 (тёмный дуб)
        ], [], 1500, 750);

        // Квест 18: 64 тропического дерева
        $this->addQuest(17, 18, [
            ItemIds::LOG . ':3' => 64  // ID 17, damage 3 (тропическое)
        ], [], 1600, 800);

        // Квест 19: 128 тропического дерева, 15 мёртвых кустов, 32 тропических листа
        $this->addQuest(18, 19, [
            ItemIds::LOG . ':3' => 128,         // ID 17, damage 3 (тропическое)
            ItemIds::DEAD_BUSH . ':0' => 15,    // ID 32, damage 0
            ItemIds::LEAVES . ':3' => 32        // ID 18, damage 3 (тропические)
        ], [], 1800, 900);

        // Квест 20: По 15 саженцев каждого дерева
        $this->addQuest(19, 20, [
            ItemIds::SAPLING . ':0' => 15,  // ID 6, damage 0 (дуб)
            ItemIds::SAPLING . ':1' => 15,  // ID 6, damage 1 (ель)
            ItemIds::SAPLING . ':2' => 15,  // ID 6, damage 2 (берёза)
            ItemIds::SAPLING . ':3' => 15   // ID 6, damage 3 (тропическое)
        ], [], 2000, 1000);

        // Квест 21: Алмазный топор
        $this->addQuest(20, 21, [
            ItemIds::DIAMOND_AXE . ':0' => 1
        ], [
            ItemIds::DIAMOND_AXE . ':0' => 1
        ], 2500, 1250);

        // Квест 22: Испытание алмазного топора
        $this->addQuest(21, 22, [
            ItemIds::LOG . ':0' => 224,   // ID 17, damage 0 (дуб)
            ItemIds::LOG . ':1' => 224,   // ID 17, damage 1 (ель)
            ItemIds::LOG . ':2' => 224,   // ID 17, damage 2 (берёза)
            ItemIds::LOG . ':3' => 224    // ID 17, damage 3 (тропическое)
        ], [], 3000, 1500);

        // Квест 23: Отдых
        $this->addRestQuest(22, 23);

        // Квест 24: Помощь строителям
        $this->addQuest(23, 24, [
            ItemIds::LOG . ':0' => 256,           // ID 17, damage 0 (дуб)
            ItemIds::LOG . ':3' => 256,           // ID 17, damage 3 (тропическое)
            ItemIds::WOODEN_SLAB . ':0' => 320    // ID 158, damage 0 (дубовые плиты)
        ], [], 3500, 1750);

        // Квест 25: Финальное испытание
        $this->addQuest(24, 25, [
            ItemIds::SAPLING . ':0' => 32,        // ID 6, damage 0 (дуб)
            ItemIds::LEAVES . ':3' => 128,        // ID 18, damage 3 (тропические)
            ItemIds::WOODEN_SLAB . ':5' => 64,    // ID 158, damage 5 (тёмный дуб)
            ItemIds::WOODEN_SLAB . ':2' => 64,    // ID 158, damage 2 (берёза)
            ItemIds::LOG . ':3' => 192,           // ID 17, damage 3 (тропическое)
            ItemIds::PLANKS . ':2' => 256         // ID 5, damage 2 (берёза)
        ], [], 5000, 2500);
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
            $this->makeTranslatedMessage("quest.woodcutter.quest{$questNumber}.first"),
            $this->makeCheckHasItems($requirements),
            $this->makeRewardGiveItems($rewards, $coins, $exp, "quest.woodcutter.quest{$questNumber}.second"),
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
            $this->makeTranslatedMessage("quest.woodcutter.quest{$questNumber}.first"),
            $this->makeCheckAlwaysTrue(),
            $this->makeRewardGiveItems([], 0, 0, "quest.woodcutter.quest{$questNumber}.second"),
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
                $playerData->getJobData()->getWoodcutter()->addExp($exp);
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
                $p->sendMessage("§b+{$exp} опыта лесоруба!");
            }
        };
    }
}
