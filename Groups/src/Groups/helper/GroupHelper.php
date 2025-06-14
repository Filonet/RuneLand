<?php

declare(strict_types=1);

namespace Groups\helper;

use Groups\types\Settings;
use PlayerData\data\PlayerDataFactory;
use PlayerData\types\Group;
use pocketmine\Player;

class GroupHelper {
    /**
     * @var string[]
     */
    public static array $tags = [];

    public function __construct(){
        //NOOP
    }

    public static function getGroupValue(string $group, ?array $groups = null): int{
        $group = strtolower($group);
        $levels = [];
        $i = 0;

        $groupAll = $groups ?? Group::all();

        while ($result = array_shift($groupAll)) {
            $i++;
            $levels[strtolower($result)] = $i;
        }

        if (!isset($levels[$group])) {
            $level = 0;
        } else {
            $level = $levels[$group];
        }

        return $level;
    }

    public static function getChat(Player $player, string $message): string{
        return str_replace(['{nickname}', '{message}'], [$player->getDisplayName(), $message], (Settings::CHAT[PlayerDataFactory::getData($player->getLowerCaseName())->getGroupData()->getGroup()] ?? Settings::CHAT[Group::NONE]));
    }

    public static function updateTags(Player $player) : void{
        $nickname = $player->getLowerCaseName();

        $tags = Settings::TAG_LIST[PlayerDataFactory::getData($nickname)->getGroupData()->getGroup()] ?? Settings::TAG_LIST[Group::NONE];

        $message = $tags['message'];

        $message = str_replace(['{name}'], [$player->getName()], $message);

        $player->setDisplayName($message);
        if (!$player->isOnline()) {
            return;
        }

        $player->setNameTag($message);

        self::$tags[$player->getName()] = $player->getNameTag();
    }
}