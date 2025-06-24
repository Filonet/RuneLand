<?php

declare(strict_types=1);

namespace Groups\task;

use Groups\helper\GroupHelper;
use PlayerData\data\PlayerDataFactory;
use PlayerData\types\Group;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class CheckTimeGroupTask extends Task {

    public function __construct(
        private Server $server
    ){
        //NOOP
    }

    public function onRun(int $currentTick) : void {
        foreach ($this->server->getOnlinePlayers() as $player) {
            $groupData = PlayerDataFactory::getData($player->getLowerCaseName())->getGroupData();
            $expirationGroup = $groupData->getExpirationGroup();
            if ($expirationGroup !== 0 && $expirationGroup < time()) {
                $groupData->setGroup(Group::NONE);

                $player->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $player->getLowerCaseName() . " " . Group::NONE);

                GroupHelper::updateTags($player);
            }
        }
    }
}