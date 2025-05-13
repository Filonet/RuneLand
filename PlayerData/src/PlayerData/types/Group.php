<?php

declare(strict_types=1);

namespace PlayerData\types;

class Group {

    public function __construct(){
        //NOOP
    }

    public const NONE = "none";
    public const GRIEFER = "griefer";
    public const HUSTANG = "hustang";
    public const GHAST = "ghast";
    public const WITHER = "wither";
    public const KRAKEN = "kraken";
    public const DRAGON = "dragon";
    public const STINGER = "stinger";
    public const ETERNITY = "eternity";

    public static function all() : array{
        return [
            self::NONE,
            self::GRIEFER,
            self::HUSTANG,
            self::GHAST,
            self::WITHER,
            self::KRAKEN,
            self::DRAGON,
            self::STINGER,
            self::ETERNITY,
        ];
    }

}