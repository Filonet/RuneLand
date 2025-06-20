<?php

declare(strict_types=1);

namespace Quest\kind;

use PlayerData\Language;
use PlayerData\types\StaticQuestData;
use pocketmine\level\particle\DustParticle;
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

        $volume = 0x10000000 * (min(30, $questData->getQuestId()) / 5); //No idea why such odd numbers, but this works...
        $player->level->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_LEVELUP, (int) $volume);

        $radius = 2.0;
        $count = 200;
        for($i = 0; $i < $count; $i++){
            $particle = new DustParticle($player->asVector3()->add(0, 3, 0), mt_rand(0, 0xff), mt_rand(0, 0xff), mt_rand(0, 0xff));

            $pitch = (mt_rand(1, mt_getrandmax() - 1) / mt_getrandmax()) * M_PI;
            $yaw = (mt_rand(1, mt_getrandmax() - 1) / mt_getrandmax()) * 2 * M_PI;

            $cosPitch = cos($pitch);
            $vector = $player->addVector((new Vector3(-sin($yaw) * $cosPitch, 3, cos($yaw) * $cosPitch))->normalize()->multiply($radius));
            $particle->x = $vector->x;
            $particle->y = $vector->y;
            $particle->z = $vector->z;

            $player->level->broadcastPacketToViewers($player, $particle->encode());
        }

        if ($kindData->isAutoTakeNextQuest()) {
            $this->find($player);
        }
    }
}