<?php

declare(strict_types=1);

namespace PlayerData\mysql;

class SaveClosureData {

    private static int $dataId = 0;

    private static array $closures = [];

    public static function getClosure(int $id) : \Closure {
        return self::$closures[$id];
    }

    public static function addClosure(\Closure $closure) : int {
        self::$closures[$id = self::$dataId++] = $closure;
        return $id;
    }

    public static function removeClosure(int $id) : void {
        unset(self::$closures[$id]);
    }

}