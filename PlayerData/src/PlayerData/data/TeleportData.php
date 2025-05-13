<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\TeleportDataHome;

class TeleportData {

    /**
     * @param TeleportDataHome[] $homes
     */
    public function __construct(
        private array $homes = []
    )
    {
    }

    public static function make() : self{
        return new self();
    }

    public function getHomes() : array{
        return $this->homes;
    }

    public function setHomes(array $homes) : void{
        $this->homes = $homes;
    }

    public function addHome(TeleportDataHome $home) : void{
        $this->homes[$home->getName()] = $home;
    }
}