<?php

declare(strict_types=1);

namespace Profession\data;

class ProfessionFactory {

    /** @var Profession[]  */
    private static array $professions = [];

    public static function init() : void {
        self::register(new MiningProfession());
    }

    private static function register(Profession $profession) : void{
        self::$professions[] = $profession;
    }

    public static function getAll() : array{
        return self::$professions;
    }
}