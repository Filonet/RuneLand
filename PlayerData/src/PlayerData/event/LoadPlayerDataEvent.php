<?php

declare(strict_types=1);

namespace PlayerData\event;

use PlayerData\data\PlayerData;
use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\Player;

class LoadPlayerDataEvent extends Event implements Cancellable {

    public function __construct(
        private Player $player,
        private PlayerData $data
    ){}

    public function getPlayer(): Player{
        return $this->player;
    }

    public function getData(): PlayerData{
        return $this->data;
    }
}