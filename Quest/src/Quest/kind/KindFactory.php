<?php

declare(strict_types=1);

namespace Quest\kind;

use NPC\entity\CustomHuman;
use NPC\Loader;
use pocketmine\level\Level;
use pocketmine\level\Location;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\SingletonTrait;

class KindFactory {
    use SingletonTrait;

    /** @var Kind[]  */
    private array $kinds = [];

    public function __construct(){
        $this->register(new Woodcutter());
        $this->register(new Miner());
        $this->register(new Farmer());
        $this->register(new Hunter());
    }

    public function register(Kind $kind) : void {
        $this->kinds[(new \ReflectionClass($kind))->getShortName()] = $kind;
    }

    public function get(string $class) : ?Kind {
        return $this->kinds[$class] ?? null;
    }

    public function getAll() : array {
        return $this->kinds;
    }

    public function spawnHumans(Level $level) : void {
        $spawning = function (string $nameTag, Vector3 $vector3, float $yaw, float $pitch, string $skinName, string $className) use ($level) : void {
            $manager = Loader::getInstance()->getManager();
            $skin = $manager->getSkin($skinName, $skinName);
            $entity = $manager->getHuman(Location::fromObject($vector3, $level, $yaw, $pitch), $skin, function (Player $player) use ($nameTag, $className) : void {
                $player->getServer()->dispatchCommand($player, "quest " . $className);
            });

            if ($entity instanceof CustomHuman) {
                $entity->spawnToAll();

                $entity->setNameTagVisible();
                $entity->setNameTagAlwaysVisible();

                $entity->setNameTag($nameTag);
            }
        };

        foreach ($this->kinds as $name => $kind) {
            $spawning(
                $kind->getNameTag(),
                $kind->getVector3(),
                $kind->getYaw(),
                $kind->getPitch(),
                $kind->getSkinName(),
                $name
            );
        }
    }
}