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
 * Фермер - NPC, который даёт квесты на получение дропов от размножаемых мобов.
 * 25 квестов от начинающего фермера до мастера животноводства.
 */
class Farmer extends Kind
{
    public function getQuestData(Player $player): StaticQuestData
    {
        return PlayerDataFactory::getData($player->getLowerCaseName())->getQuestData()->getFarmer();
    }

    public function getNameTag(): string   { return 'Farmer'; }
    public function getVector3(): Vector3  { return new Vector3(185.5, 119, 165.5); }
    public function getYaw(): float        { return 90; }
    public function getPitch(): float      { return 0; }
    public function getSkinName(): string  { return 'farmer'; }

    /* ─────────────── Конструктор с квестами ─────────────── */

    public function __construct()
    {
        // Квест 1: Первые яйца
        $this->addQuest(0, 1, [
            ItemIds::EGG . ':0' => 10  // ID 344, damage 0
        ], [], 120, 60);

        // Квест 2: Куриное мясо
        $this->addQuest(1, 2, [
            ItemIds::RAW_CHICKEN . ':0' => 5  // ID 365, damage 0
        ], [], 150, 75);

        // Квест 3: Перья для подушек
        $this->addQuest(2, 3, [
            ItemIds::FEATHER . ':0' => 15  // ID 288, damage 0
        ], [], 180, 90);

        // Квест 4: Свинина для пира
        $this->addQuest(3, 4, [
            ItemIds::RAW_PORKCHOP . ':0' => 8  // ID 319, damage 0
        ], [], 200, 100);

        // Квест 5: Кожа для ремесла
        $this->addQuest(4, 5, [
            ItemIds::LEATHER . ':0' => 12  // ID 334, damage 0
        ], [], 250, 125);

        // Квест 6: Говядина высшего качества
        $this->addQuest(5, 6, [
            ItemIds::RAW_BEEF . ':0' => 6  // ID 363, damage 0
        ], [], 300, 150);

        // Квест 7: Шерсть для одежды
        $this->addQuest(6, 7, [
            ItemIds::WOOL . ':0' => 20  // ID 35, damage 0 (белая шерсть)
        ], [], 350, 175);

        // Квест 8: Отдых - забота о животных
        $this->addRestQuest(7, 8);

        // Квест 9: Разнообразие мяса
        $this->addQuest(8, 9, [
            ItemIds::RAW_CHICKEN . ':0' => 10,  // курица
            ItemIds::RAW_PORKCHOP . ':0' => 10, // свинина
            ItemIds::RAW_BEEF . ':0' => 8       // говядина
        ], [], 450, 225);

        // Квест 10: Большая партия яиц
        $this->addQuest(9, 10, [
            ItemIds::EGG . ':0' => 32
        ], [], 500, 250);

        // Квест 11: Цветная шерсть
        $this->addQuest(10, 11, [
            ItemIds::WOOL . ':0' => 16,   // белая
            ItemIds::WOOL . ':1' => 16,   // оранжевая
            ItemIds::WOOL . ':2' => 16,   // пурпурная
            ItemIds::WOOL . ':3' => 16    // голубая
        ], [], 600, 300);

        // Квест 12: Кролиководство
        $this->addQuest(11, 12, [
            ItemIds::RAW_RABBIT . ':0' => 15,    // ID 411, damage 0
            ItemIds::RABBIT_HIDE . ':0' => 10    // ID 415, damage 0
        ], [], 650, 325);

        // Квест 13: Баранина для ресторана
        $this->addQuest(12, 13, [
            ItemIds::RAW_MUTTON . ':0' => 12  // ID 423, damage 0
        ], [], 700, 350);

        // Квест 14: Массовое производство кожи
        $this->addQuest(13, 14, [
            ItemIds::LEATHER . ':0' => 32
        ], [], 800, 400);

        // Квест 15: Пёстрая шерсть
        $this->addQuest(14, 15, [
            ItemIds::WOOL . ':4' => 12,   // жёлтая
            ItemIds::WOOL . ':5' => 12,   // лаймовая
            ItemIds::WOOL . ':6' => 12,   // розовая
            ItemIds::WOOL . ':7' => 12,   // серая
            ItemIds::WOOL . ':8' => 12    // светло-серая
        ], [], 900, 450);

        // Квест 16: Птицефабрика
        $this->addQuest(15, 16, [
            ItemIds::RAW_CHICKEN . ':0' => 25,
            ItemIds::FEATHER . ':0' => 40,
            ItemIds::EGG . ':0' => 48
        ], [], 1000, 500);

        // Квест 17: Отдых - улучшение фермы
        $this->addRestQuest(16, 17);

        // Квест 18: Мясной ассортимент
        $this->addQuest(17, 18, [
            ItemIds::RAW_BEEF . ':0' => 20,
            ItemIds::RAW_PORKCHOP . ':0' => 20,
            ItemIds::RAW_MUTTON . ':0' => 15,
            ItemIds::RAW_RABBIT . ':0' => 25
        ], [], 1200, 600);

        // Квест 19: Радужная шерсть
        $this->addQuest(18, 19, [
            ItemIds::WOOL . ':9' => 10,   // циановая
            ItemIds::WOOL . ':10' => 10,  // фиолетовая
            ItemIds::WOOL . ':11' => 10,  // синяя
            ItemIds::WOOL . ':12' => 10,  // коричневая
            ItemIds::WOOL . ':13' => 10,  // зелёная
            ItemIds::WOOL . ':14' => 10,  // красная
            ItemIds::WOOL . ':15' => 10   // чёрная
        ], [], 1400, 700);

        // Квест 20: Кожевенное дело
        $this->addQuest(19, 20, [
            ItemIds::LEATHER . ':0' => 64,
            ItemIds::RABBIT_HIDE . ':0' => 32
        ], [], 1600, 800);

        // Квест 21: Отдых - модернизация оборудования
        $this->addRestQuest(20, 21);

        // Квест 22: Промышленное животноводство
        $this->addQuest(21, 22, [
            ItemIds::RAW_BEEF . ':0' => 40,
            ItemIds::RAW_PORKCHOP . ':0' => 40,
            ItemIds::RAW_CHICKEN . ':0' => 50,
            ItemIds::RAW_MUTTON . ':0' => 30,
            ItemIds::RAW_RABBIT . ':0' => 35
        ], [], 2000, 1000);

        // Квест 23: Перьевая подушка
        $this->addQuest(22, 23, [
            ItemIds::FEATHER . ':0' => 128
        ], [], 2500, 1250);

        // Квест 24: Шерстяная империя
        $this->addQuest(23, 24, [
            ItemIds::WOOL . ':0' => 64,   // белая
            ItemIds::WOOL . ':1' => 32,   // оранжевая
            ItemIds::WOOL . ':4' => 32,   // жёлтая
            ItemIds::WOOL . ':11' => 32,  // синяя
            ItemIds::WOOL . ':14' => 32,  // красная
            ItemIds::WOOL . ':15' => 32   // чёрная
        ], [], 3000, 1500);

        // Квест 25: Мастер животноводства
        $this->addQuest(24, 25, [
            ItemIds::EGG . ':0' => 128,
            ItemIds::LEATHER . ':0' => 96,
            ItemIds::RAW_BEEF . ':0' => 64,
            ItemIds::RAW_PORKCHOP . ':0' => 64,
            ItemIds::RAW_CHICKEN . ':0' => 80,
            ItemIds::FEATHER . ':0' => 160,
            ItemIds::WOOL . ':0' => 128
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
            $this->makeTranslatedMessage("quest.farmer.quest{$questNumber}.first"),
            $this->makeCheckHasItems($requirements),
            $this->makeRewardGiveItems($rewards, $coins, $exp, "quest.farmer.quest{$questNumber}.second"),
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
            $this->makeTranslatedMessage("quest.farmer.quest{$questNumber}.first"),
            $this->makeCheckAlwaysTrue(),
            $this->makeRewardGiveItems([], 0, 0, "quest.farmer.quest{$questNumber}.second"),
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
                $playerData->getJobData()->getFarmer()->addExp($exp);
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
                $p->sendMessage("§b+{$exp} опыта фермера!");
            }
        };
    }
} 