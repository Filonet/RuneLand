<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\Language;
use PlayerData\types\StaticQuestData;
use pocketmine\Player;

abstract class Kind {

    /** @var KindData[] */
    private array $quests = [];

    abstract public function __construct();

    abstract public function getQuestData(Player $player) : StaticQuestData;

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

            $questData->setTake(true); //TODO: set database
            return;
        }

        if (!(($kindData->getCheck())($player))) {
            return;
        }

        $success = $kindData->getSuccess();
        if ($success !== null) {
            ($kindData->getSuccess())($player);
        }

        $questData->setQuestId($questData->getQuestId() + 1); //TODO: set database

        if ($kindData->isAutoTakeNextQuest()) {
            $this->find($player);
        }
    }
}