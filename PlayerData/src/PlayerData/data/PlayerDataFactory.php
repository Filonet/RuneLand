<?php

declare(strict_types=1);

namespace PlayerData\data;

class PlayerDataFactory {

    /** @var PlayerData[] */
    private static array $players = [];

    /**
     * @param string $nickname
     * @return PlayerData
     */
    public static function getData(string $nickname) : PlayerData{
        return self::$players[strtolower($nickname)] ?? PlayerData::make();
    }

    /**
     * @param string $nickname
     * @param PlayerData $data
     */
    public static function setData(string $nickname, PlayerData $data) : void{
        self::$players[$nickname] = $data;
    }

    /**
     * @param string $nickname
     * @return bool
     */
    public static function isData(string $nickname) : bool{
        return isset(self::$players[$nickname]);
    }

    /**
     * @param string $nickname
     */
    public static function delData(string $nickname) : void{
        if (self::isData($nickname)) {
            unset(self::$players[$nickname]);
        }
    }
}