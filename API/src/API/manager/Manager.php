<?php

declare(strict_types=1);

namespace API\manager;

use API\Loader;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;

class Manager {
    /** @var bool[] */
    private array $teleports = [];
    /** @var bool[] */
    private array $randomTeleports = [];

    public function __construct(
        private Loader $loader
    ){}

    public function randomTeleport(Player $player) : void {
        $x = mt_rand(-2000, 2000);
        $z = mt_rand(-2000, 2000);

        $spawnLocation = new Position($x, 200, $z, $this->loader->getServer()->getLevelByName("survival"));

        $player->teleport($spawnLocation);

        $player->sendMessage(Language::translate("%api.teleport.on.survival%", $player, [
            "x" => $spawnLocation->getFloorX(),
            "y" => $spawnLocation->getFloorY(),
            "z" => $spawnLocation->getFloorZ()
        ]));

        $this->randomTeleports[$player->getLowerCaseName()] = true;

        $this->loader->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($player) : void {
            unset($this->randomTeleports[$player->getLowerCaseName()]);
        }), 20 * 20);
    }

    public function isRandomTeleport(Player $player) : bool {
        return isset($this->randomTeleports[$player->getLowerCaseName()]);
    }

    public function teleport(Player $player, Vector3 $vector3, int $timer, string $customName = null) : void {
        if ($customName === null) {
            $player->sendMessage(Language::translate("%api.teleport.timer.teleportation%", $player));
        } else {
            $player->sendMessage(Language::translate("%api.teleport.timer.teleportation.target%", $player, ["target" => $customName]));
        }

        $player->sendMessage(Language::translate("%api.teleport.timer.count%", $player, [
            "timer" => $timer
        ]));

        $this->teleports[$player->getLowerCaseName()] = true;

        $this->loader->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($player, $vector3, $timer, $customName) : void {
            if (!$player->isConnected()) return;

            if (isset($this->teleports[$player->getLowerCaseName()])) {
                $player->teleport($vector3);

                $player->sendMessage(Language::translate("%api.teleport.timer.success%", $player));

                unset($this->teleports[$player->getLowerCaseName()]);
            }
        }), $timer * 20);
    }

    public function cancelTeleport(Player $player) : void {
        if (isset($this->teleports[$player->getLowerCaseName()])) {
            $player->sendMessage(Language::translate("%api.teleport.timer.cancel%", $player));

            unset($this->teleports[$player->getLowerCaseName()]);
        }
    }

    /*
     * Выводим наигранное время тоже
     */
    public function getGameTime(Player $player) : int {
        $nickname = $player->getLowerCaseName();

        $total = 0;
        $total += PlayerDataFactory::getData($nickname)->getStatsData()->getGameTime();
        if (isset(Loader::$playerTimes[$nickname])){
            $total += time() - Loader::$playerTimes[$nickname];
        }

        return $total;
    }
}