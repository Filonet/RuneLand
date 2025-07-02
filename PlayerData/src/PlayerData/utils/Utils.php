<?php

declare(strict_types=1);

namespace PlayerData\utils;

class Utils {

    public function __construct(){
        //NOOP
    }

    public static function encryptionPassword(string $password) : string{
        return hash("sha512", "SDFsrte5rtrfEtFdsvfgeRYERUJHTDJfasq" . $password);
    }
}