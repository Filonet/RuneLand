<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\SessionIds;

class AuthData {

    public function __construct(
        private string  $password = '',
        private string  $address = '',
        private int     $stage = SessionIds::NONE,
    )
    {
    }

    public static function make() : self{
        return new self();
    }

    public function getPassword() : string{
        return $this->password;
    }

    public function getAddress() : string{
        return $this->address;
    }

    public function getStage() : int{
        return $this->stage;
    }

    public function setPassword(string $password) : void{
        $this->password = $password;
    }

    public function setAddress(string $address) : void{
        $this->address = $address;
    }

    public function setStage(int $stage) : void{
        $this->stage = $stage;
    }
}