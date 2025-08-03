<?php

declare(strict_types=1);

namespace DonateCase\task;

use DonateCase\types\AnimateItem;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\level\sound\ExpPickupSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddItemActorPacket;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\network\mcpe\protocol\RemoveActorPacket;
use pocketmine\scheduler\Task;

class AnimateCaseTask extends Task {
    private int $tick = 0;
    private int $entityRuntimeId = -1;
    private Vector3 $position;
    private int $maxChance = 0;
    private AnimateItem $lastGift;

    /**
     * @param AnimateItem[] $items
     */
    public function __construct(
        private Level    $level,
        private Vector3  $startPosition,
        private int      $count,
        private array    $items,
        private \Closure $win,
        private \Closure $end
    ){
        $this->position = $this->startPosition;

        foreach ($this->items as $item) {
            $this->maxChance += $item->getChance();
        }
    }

    public function onRun(int $currentTick): void{
        $this->tick++;

        $startPosition = $this->startPosition;
        if ($this->tick === 1) {
            $this->level->addSound(new BlazeShootSound($startPosition));

            $packet = new BlockEventPacket();
            $packet->x = (int) $startPosition->x;
            $packet->y = (int) $startPosition->y;
            $packet->z = (int) $startPosition->z;
            $packet->eventType = 1; //it's always 1 for a chest
            $packet->eventData = 1;
            $this->level->broadcastPacketToViewers($startPosition, $packet);

            $this->level->broadcastLevelSoundEvent($startPosition, LevelSoundEventPacket::SOUND_CHEST_OPEN);
        } elseif ($this->tick < $this->count) {
            $item = $this->lastGift = $this->getRandomItem();

            if ($this->entityRuntimeId !== -1) {
                $packet = new RemoveActorPacket();
                $packet->entityUniqueId = $this->entityRuntimeId;
                $this->level->broadcastPacketToViewers($startPosition, $packet);
            }

            $this->entityRuntimeId = Entity::$entityCount++;

            $packet = new AddItemActorPacket();
            $packet->entityRuntimeId = $this->entityRuntimeId;
            $packet->position = $this->position;
            $packet->motion = null;
            $packet->item = $item->getItem();
            $flags = (
                (1 << Entity::DATA_FLAG_CAN_SHOW_NAMETAG) |
                (1 << Entity::DATA_FLAG_ALWAYS_SHOW_NAMETAG) |
                (1 << Entity::DATA_FLAG_IMMOBILE)
            );
            $packet->metadata = [
                Entity::DATA_FLAGS => [Entity::DATA_TYPE_LONG, $flags],
                Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, $item->getName()]
            ];
            $this->level->broadcastPacketToViewers($startPosition, $packet);
            if ($this->tick < ($this->count * 0.8)) {
                $this->position = $this->position->add(0, 0.2, 0);
            }

            $this->level->addSound(new ExpPickupSound($startPosition));
        } elseif ($this->tick < ($this->count + ($this->count * 0.8))) {
            $this->position = $this->position->add(0, -0.7, 0);

            $startY = ($startPosition->getY() + 1);
            if ($this->position->getY() <= $startY) {
                $this->position = $startPosition->add(0, 1, 0);
            }

            $packet = new MoveActorAbsolutePacket();
            $packet->entityRuntimeId = $this->entityRuntimeId;
            $packet->position = $this->position;
            $packet->pitch = $packet->yaw = $packet->headYaw = 0;
            $this->level->broadcastPacketToViewers($startPosition, $packet);

            if ($this->tick === $this->count) {
                ($this->win)($this->lastGift);

                $this->level->getServer()->dispatchCommand(new ConsoleCommandSender(), $this->lastGift->getCommand());

                $this->level->broadcastLevelEvent($startPosition, LevelEventPacket::EVENT_SOUND_TOTEM);

                $radius = 2.0;
                $count = 650;
                for($i = 0; $i < $count; $i++){
                    $particle = new DustParticle($this->position, mt_rand(0, 0xff), mt_rand(0, 0xff), mt_rand(0, 0xff));

                    $yaw = (mt_rand(1, mt_getrandmax() - 1) / mt_getrandmax()) * 2 * M_PI;

                    $vector = $this->position->addVector((new Vector3(-sin($yaw), 0, cos($yaw)))->normalize()->multiply($radius));
                    $particle->x = $vector->x;
                    $particle->y = $vector->y;
                    $particle->z = $vector->z;

                    $this->level->broadcastPacketToViewers($startPosition, $particle->encode());
                }
            }
        } else {
            if ($this->entityRuntimeId !== -1) {
                $packet = new RemoveActorPacket();
                $packet->entityUniqueId = $this->entityRuntimeId;
                $this->level->broadcastPacketToViewers($startPosition, $packet);
            }

            $this->getHandler()->cancel();

            $packet = new BlockEventPacket();
            $packet->x = (int) $startPosition->x;
            $packet->y = (int) $startPosition->y;
            $packet->z = (int) $startPosition->z;
            $packet->eventType = 1; //it's always 1 for a chest
            $packet->eventData = 0;
            $this->level->broadcastPacketToViewers($startPosition, $packet);

            $this->level->broadcastLevelSoundEvent($startPosition, LevelSoundEventPacket::SOUND_CHEST_CLOSED);

            ($this->end)();
        }
    }

    private function getRandomItem() : AnimateItem {
        $items = [];

        foreach ($this->items as $item) {
            for ($i = 0; $i < $item->getChance(); $i++) {
                $items[] = $item;
            }
        }

        return $items[array_rand($items)];
    }
}