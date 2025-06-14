<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\SessionIds;

class StatsData {

    public function __construct(
        private int $money = 0,
        private int $runes = 0,
        private int $kills = 0,
        private int $deaths  = 0,
        private int $gameTime = 0
    )
    {
    }

    public static function make() : self{
        return new self();
    }

    public function getMoney() : int{
        return $this->money;
    }

    public function getRunes() : int{
        return $this->runes;
    }

    public function getKills() : int {
        return $this->kills;
    }

    public function getDeaths() : int {
        return $this->deaths;
    }

    public function getGameTime() : int {
        return $this->gameTime;
    }

    public function setMoney(int $money) : void{
        $this->money = $money;
    }

    public function addMoney(int $money) : void{
        $this->money += $money;
    }

    public function setRunes(int $runes) : void{
        $this->runes = $runes;
    }

    public function addRunes(int $runes) : void{
        $this->runes += $runes;
    }

    public function setKills(int $kills) : void{
        $this->kills = $kills;
    }

    public function addKills(int $kills) : void{
        $this->kills += $kills;
    }

    public function setDeaths(int $deaths) : void{
        $this->deaths = $deaths;
    }

    public function addDeaths(int $deaths) : void{
        $this->deaths += $deaths;
    }

    public function setGameTime(int $gameTime) : void{
        $this->gameTime = $gameTime;
    }
}