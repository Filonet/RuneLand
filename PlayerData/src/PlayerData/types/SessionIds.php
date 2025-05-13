<?php

declare(strict_types=1);

namespace PlayerData\types;

class SessionIds {
    public function __construct(){
        //NOOP
    }

    public const int NONE = -1;
    public const int LOGIN = 0;
    public const int REGISTER = 1;
    public const int SUCCESS = 2;

}