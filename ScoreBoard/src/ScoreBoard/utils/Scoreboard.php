<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace ScoreBoard\utils;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\Player;

class Scoreboard{
    private Objective $objective;
    private int $entryId = 0;
    /** @var ScorePacketEntry[] */
    private array $entries = [];

    private Player $player;

    public function __construct(Player $player, Objective $objective){
        $this->player = $player;
        $this->objective = $objective;

        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = $objective->displaySlot->name();
        $pk->objectiveName = $objective->objectiveName;
        $pk->displayName = $objective->displayName;
        $pk->criteriaName = $objective->criteriaName;
        $pk->sortOrder = $objective->sortOrder->getMagicNumber();
        $player->sendDataPacket($pk);
    }

    /**
     * @return Objective
     */
    public function getObjective() : Objective{
        return $this->objective;
    }

    /**
     * @return ScorePacketEntry[]
     */
    public function getEntries() : array{
        return $this->entries;
    }

    /**
     * @param string $name
     *
     * @return int|null
     */
    public function getScore(string $name) : ?int{
        return $this->entries[$name]->score ?? null;
    }

    /**
     * @param string $name
     * @param int    $score
     */
    public function setScore(string $name, int $score) : void{
        if(isset($this->entries[$name])){
            $entry = $this->entries[$name];
            if($entry->score === $score){
                return;
            }
        }else{
            $entry = new ScorePacketEntry();
            $entry->scoreboardId = $this->entryId++;
            $entry->objectiveName = $this->objective->objectiveName;
            $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
            $entry->customName = $name;
        }
        $entry->score = $score;
        $this->entries[$name] = $entry;

        $pk = new SetScorePacket();
        $pk->type = SetScorePacket::TYPE_CHANGE;
        $pk->entries = [$entry];

        $this->player->sendDataPacket($pk);
    }

    public function clearEntries() : void{
        $pk = new SetScorePacket();
        $pk->type = SetScorePacket::TYPE_REMOVE;
        $pk->entries = $this->entries;
        $this->player->sendDataPacket($pk);

        $this->entries = [];
    }

    /**
     * @param string $name
     */
    public function removeScore(string $name) : void{
        if(isset($this->entries[$name])){
            $entry = $this->entries[$name];

            $pk = new SetScorePacket();
            $pk->type = SetScorePacket::TYPE_REMOVE;
            $pk->entries = [$entry];
            $this->player->sendDataPacket($pk);

            unset($this->entries[$name]);
        }
    }

    public function remove() : void{
        $pk = new RemoveObjectivePacket();
        $pk->objectiveName = $this->objective->objectiveName;
        $this->player->sendDataPacket($pk);

        $pk = new SetScorePacket();
        $pk->type = SetScorePacket::TYPE_REMOVE;
        $pk->entries = $this->entries;
        $this->player->sendDataPacket($pk);
    }
}