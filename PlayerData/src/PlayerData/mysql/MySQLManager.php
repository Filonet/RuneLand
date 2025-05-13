<?php

declare(strict_types=1);

namespace PlayerData\mysql;

use mysqli;

final class MySQLManager {

    public const HOST = 'mypex.ru';
    public const USER = 'monty';
    public const PASSWORD = 'Wh9R01V0Mb@';
    public const PORT = 3306;

    private const REQUIRED_DB = [
        'runeland'
    ];

    private static array $databases = [];

    public static function init() : void{
        foreach (self::REQUIRED_DB as $dbName) {
            self::connect($dbName);
        }
    }

    public static function connect(string $dbName) : mysqli{
        if (!isset(self::$databases[$dbName])) {
            self::$databases[$dbName] = new mysqli(self::HOST, self::USER, self::PASSWORD, $dbName, self::PORT);
        }
        return self::$databases[$dbName];
    }

    public static function runeland() : mysqli{
        return self::connect('runeland');
    }
}