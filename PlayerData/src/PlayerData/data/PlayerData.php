<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\Group;
use PlayerData\types\Title;

class PlayerData {

    public function __construct(
        private AuthData        $authData,
        private GroupData       $groupData,
        private StatsData       $statsData,
        private QuestData       $questData,
        private TeleportData    $teleportData,
        private int             $cid = 0
    ) {}

    public static function make(): PlayerData{
        return new self(
            AuthData::make(),
            GroupData::make(),
            StatsData::make(),
            QuestData::make(),
            TeleportData::make()
        );
    }

    public function getAuthData() : AuthData{
        return $this->authData;
    }

    public function getGroupData() : GroupData{
        return $this->groupData;
    }

    public function getStatsData() : StatsData{
        return $this->statsData;
    }

    public function getQuestData() : QuestData{
        return $this->questData;
    }

    public function getTeleportData() : TeleportData{
        return $this->teleportData;
    }

    public function getCid() : int{
        return $this->cid;
    }

    public function setAuthData(AuthData $data) : void{
        $this->authData = $data;
    }

    public function setGroupData(GroupData $data) : void{
        $this->groupData = $data;
    }

    public function setStatsData(StatsData $data) : void{
        $this->statsData = $data;
    }

    public function setQuestData(QuestData $questData) : void{
        $this->questData = $questData;
    }

    public function setTeleportData(TeleportData $teleportData) : void{
        $this->teleportData = $teleportData;
    }

    public function setCid(int $cid) : void{
        $this->cid = $cid;
    }
}