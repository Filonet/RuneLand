<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\helper\PlayerDataHelper;
use PlayerData\Language;
use PlayerData\types\StaticQuestData;
use PlayerData\types\Title;
use pocketmine\item\ItemFactory;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

abstract class Kind {

    /** @var KindData[] */
    private array $quests = [];

    abstract public function __construct();

    abstract public function getQuestData(Player $player) : StaticQuestData;

    abstract public function getNameTag() : string;

    abstract public function getVector3() : Vector3;

    abstract public function getYaw() : float;

    abstract public function getPitch() : float;

    abstract public function getSkinName() : string;

    abstract public function getLanguageKey() : string;

    abstract public function getDataBaseKey() : string;

    public function add(int $id, KindData $data) : void {
        $this->quests[$id] = $data;
    }

    public function get(int $id) : ?KindData {
        return $this->quests[$id] ?? null;
    }

    public function find(Player $player) : void {
        $kindData = $this->get(($questData = $this->getQuestData($player))->getQuestId());
        if ($kindData === null) {
            $player->sendMessage(Language::translate("%quest.all.passed%", $player));
            return;
        }

        if (!$questData->isTake()) {
            ($kindData->getTake())($player);

            $questData->setTake(true);

            \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `' . $this->getDataBaseKey() . '` (`nickname`, `questId`, `isTake`, `progress`) VALUES("' . $player->getLowerCaseName() . '", "' . $questData->getQuestId() . '", "' . (int) $questData->isTake() . '", "' . $questData->getProgress() . '") ON DUPLICATE KEY UPDATE `questId` = "' . $questData->getQuestId() . '", `isTake` = "' . (int) $questData->isTake() . '", `progress` = "' . $questData->getProgress() . '";');
            return;
        }

        if (!(($kindData->getCheck())($player))) {
            return;
        }

        $success = $kindData->getSuccess();
        if ($success !== null) {
            ($kindData->getSuccess())($player);
        }

        $questData->setQuestId($questData->getQuestId() + 1);

        $volume = 0x10000000 * (min(30, $questData->getQuestId()) / 5); //No idea why such odd numbers, but this works...
        $player->level->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_LEVELUP, (int) $volume);

        $center = Position::fromObject($this->getVector3(), $player->getLevel());
        $size = 4;
        $count = 80;

        for ($yaw = 0, $y = $center->y; $y < $center->y + $size; $yaw += (M_PI * 2) / 100, $y += 1 / $count) {
            $particle = new DustParticle($center, mt_rand(0, 0xff), mt_rand(0, 0xff), mt_rand(0, 0xff));

            $x = -sin($yaw) + $center->x;
            $z = cos($yaw) + $center->z;
            $particle->x = $x;
            $particle->y = $y;
            $particle->z = $z;
            $center->getLevel()->addParticle($particle);
        }

        if ($kindData->isAutoTakeNextQuest()) {
            $this->find($player);
        }

        $questData->setTake(false);
        $questData->setProgress(0.0);

        \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `' . $this->getDataBaseKey() . '` (`nickname`, `questId`, `isTake`, `progress`) VALUES("' . $player->getLowerCaseName() . '", "' . $questData->getQuestId() . '", "' . (int) $questData->isTake() . '", "' . $questData->getProgress() . '") ON DUPLICATE KEY UPDATE `questId` = "' . $questData->getQuestId() . '", `isTake` = "' . (int) $questData->isTake() . '", `progress` = "' . $questData->getProgress() . '";');
    }

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
    protected function addQuest(int $questId, int $questNumber, array $requirements, array $rewards = [], int $coins = 0, int $exp = 0): void{
        $this->add($questId, new KindData(
            $this->makeTranslatedMessage("quest." . $this->getLanguageKey() . ".quest{$questNumber}.first"),
            $this->makeCheckHasItems($requirements),
            $this->makeRewardGiveItems($rewards, $coins, $exp, "quest." . $this->getLanguageKey() . ".quest{$questNumber}.second"),
            false
        ));
    }

    /**
     * Добавляет квест-отдых без требований.
     *
     * @param int $questId ID квеста
     * @param int $questNumber Номер квеста для языковых строк
     */
    protected function addRestQuest(int $questId, int $questNumber): void{
        $this->add($questId, new KindData(
            $this->makeTranslatedMessage("quest." . $this->getLanguageKey() . ".quest{$questNumber}.first"),
            $this->makeCheckAlwaysTrue(),
            $this->makeRewardGiveItems([], 0, 0, "quest." . $this->getLanguageKey() . ".quest{$questNumber}.second"),
            false
        ));
    }

    /**
     * Создаёт колбэк для отправки переведённого сообщения.
     */
    protected function makeTranslatedMessage(string $langKey): callable{
        return fn(Player $p) => $p->sendMessage(Language::translate("%{$langKey}%", $p));
    }

    /**
     * Проверка: в инвентаре есть ВСЕ требуемые предметы/кол-ва с учётом damage values.
     * @param array $requirements Требования в формате ['itemId:damage' => amount]
     */
    protected function makeCheckHasItems(array $requirements): callable{
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
    protected function makeCheckAlwaysTrue(): callable{
        return fn(Player $p): bool => true;
    }

    /**
     * Награда: опыт → деньги → предметы.
     *
     * @param array $items  Предметы в формате ['itemId:damage' => amount]
     * @param int   $coins  Сколько монет начислить
     * @param int   $exp    Сколько опыта профессии дать
     * @param string $languageKey Ключ языкового сообщения игроку
     */
    protected function makeRewardGiveItems(
        array $items = [],
        int $coins = 0,
        int $exp = 0,
        string $languageKey = ''
    ): callable {
        return function (Player $player) use ($items, $coins, $exp, $languageKey): void {
            // Добавляем опыт
            //if ($exp > 0) {
            //    $playerData = PlayerDataFactory::getData($p->getLowerCaseName());
            //    $playerData->getJobData()->getFarmer()->addExp($exp);
            //}

            if ($coins > 0) {
                PlayerDataHelper::getInstance()->addMoney($player->getLowerCaseName(), $coins);
                $player->sendMessage("§a+{$coins} монет!");
            }

            foreach ($items as $itemKey => $amount) {
                [$itemId, $damage] = explode(':', $itemKey);
                $item = ItemFactory::get((int)$itemId, (int)$damage, $amount);
                if ($player->getInventory()->canAddItem($item)) {
                    $player->getInventory()->addItem($item);
                } else {
                    $player->getLevel()->dropItem($player, $item);
                }
            }

            if ($languageKey !== '') {
                $player->sendMessage(Language::translate("%{$languageKey}%", $player));
            }

            // Показываем полученный опыт
            //if ($exp > 0) {
            //    $p->sendMessage("§b+{$exp} опыта фермера!");
            //}
        };
    }
}