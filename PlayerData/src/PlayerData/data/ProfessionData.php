<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\SessionIds;

class ProfessionData{

    public function __construct(
        private int $level = 0,
        private int $experience = 0
    )
    {
    }

    public static function make(): self{
        return new self();
    }

    public function getLevel() : int{
        return $this->level;
    }

    public function getExperience() : int{
        return $this->experience;
    }

    public function setLevel(int $level) : void{
        $this->level = $level;
    }

    public function addLevel(int $level) : void{
        $this->level += $level;
    }

    public function setExperience(int $experience) : void{
        $this->experience = $experience;
    }

    public function addExperience(int $experience) : void{
        $this->experience += $experience;
    }
}