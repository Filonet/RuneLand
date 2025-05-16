<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\SessionIds;
use PlayerData\types\StaticQuestData;

class QuestData {

    public function __construct(
        private StaticQuestData $woodcutter,
        private StaticQuestData $miner,
        private StaticQuestData $farmer,
        private StaticQuestData $hunter
    )
    {
    }

    public static function make() : self{
        return new self(
            StaticQuestData::make(),
            StaticQuestData::make(),
            StaticQuestData::make(),
            StaticQuestData::make()
        );
    }

    public function getWoodcutter() : StaticQuestData{
        return $this->woodcutter;
    }

    public function getMiner() : StaticQuestData{
        return $this->miner;
    }

    public function getFarmer() : StaticQuestData{
        return $this->farmer;
    }

    public function getHunter() : StaticQuestData{
        return $this->hunter;
    }
}