<?php

declare(strict_types=1);

namespace PlayerData\types;

class TeleportDataHome {

    public function __construct(
        private mixed $name,
        private int $x,
        private int $y,
        private int $z,
    ){}

    public function getName() : mixed{
        return $this->name;
    }

    public function getX() : int{
        return $this->x;
    }

    public function getY() : int{
        return $this->y;
    }

    public function getZ() : int{
        return $this->z;
    }

}