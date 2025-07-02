<?php

declare(strict_types=1);

namespace PlayerData\types;

class Group {

    public function __construct(){
        //NOOP
    }

    public const NONE = "none";
    public const HERO = "hero";
    public const HUNTER = "hunter";
    public const RANGER = "ranger";
    public const ELEMENTAL = "elemental";
    public const PHANTOM = "phantom";
    public const ARCANA = "arcana";
    public const TITAN = "titan";
    public const ELDER = "elder";

    public static function all() : array{
        return [
            self::NONE,
            self::HERO,
            self::HUNTER,
            self::RANGER,
            self::ELEMENTAL,
            self::PHANTOM,
            self::ARCANA,
            self::TITAN,
            self::ELDER
        ];
    }

}