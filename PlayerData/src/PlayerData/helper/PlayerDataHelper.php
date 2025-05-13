<?php

declare(strict_types=1);

namespace PlayerData\helper;

use PlayerData\data\PlayerDataFactory;
use PlayerData\Loader;
use pocketmine\utils\SingletonTrait;

class PlayerDataHelper {
    use SingletonTrait;

    public function __construct(){
        //NOOP
    }

    public function getMoney(string $nickname): int{
        return PlayerDataFactory::getData(strtolower($nickname))->getStatsData()->getMoney();
    }

    public function addMoney(string $nickname, int $money): void{
        PlayerDataFactory::getData($nickname = strtolower($nickname))->getStatsData()->addMoney($money);

        Loader::$mThread->pushQueryPacket('INSERT INTO `stats` (`nickname`, `money`, `runes`, `kills`, `deaths`) VALUES("' . $nickname . '", ' . $money . ', 0, 0, 0) ON DUPLICATE KEY UPDATE `money` = `money` + ' . $money . ';');
    }

    public function delMoney(string $nickname, int $money): void{
        self::addMoney($nickname, -$money);
    }

    public function getRunes(string $nickname): int{
        return PlayerDataFactory::getData(strtolower($nickname))->getStatsData()->getRunes();
    }

    public function addRunes(string $nickname, int $runes): void{
        PlayerDataFactory::getData($nickname = strtolower($nickname))->getStatsData()->addRunes($runes);

        Loader::$mThread->pushQueryPacket('INSERT INTO `stats` (`nickname`, `money`, `runes`, `kills`, `deaths`) VALUES("' . $nickname . '", 0, ' . $runes . ', 0, 0) ON DUPLICATE KEY UPDATE `runes` = `runes` + ' . $runes . ';');
    }

    public function delRunes(string $nickname, int $runes): void{
        self::addRunes($nickname, -$runes);
    }
}