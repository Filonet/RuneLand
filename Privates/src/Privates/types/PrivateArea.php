<?php

namespace Privates\types;

use pocketmine\level\Position;

class PrivateArea {

    /** @var string */
    private $id;
    
    /** @var string */
    private $owner;
    
    /** @var Position */
    private $center;
    
    /** @var string */
    private $world;
    
    /** @var int */
    private $size;
    
    /** @var array */
    private $members;
    
    /** @var int */
    private $blockType;

    public function __construct(string $id, string $owner, Position $center, string $world, int $size, array $members, int $blockType) {
        $this->id = $id;
        $this->owner = $owner;
        $this->center = $center;
        $this->world = $world;
        $this->size = $size;
        $this->members = $members;
        $this->blockType = $blockType;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getOwner(): string {
        return $this->owner;
    }

    public function setOwner(string $owner): void {
        $this->owner = $owner;
    }

    public function getCenter(): Position {
        return $this->center;
    }

    public function getWorld(): string {
        return $this->world;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function getMembers(): array {
        return $this->members;
    }

    public function addMember(string $player): void {
        if (!in_array($player, $this->members)) {
            $this->members[] = $player;
        }
    }

    public function removeMember(string $player): void {
        $key = array_search($player, $this->members);
        if ($key !== false) {
            unset($this->members[$key]);
            $this->members = array_values($this->members);
        }
    }

    public function isMember(string $player): bool {
        return in_array($player, $this->members);
    }

    public function getBlockType(): int {
        return $this->blockType;
    }

    public function isInside(Position $position): bool {
        $radius = floor($this->size / 2);
        
        return abs($position->x - $this->center->x) <= $radius &&
               abs($position->y - $this->center->y) <= $radius &&
               abs($position->z - $this->center->z) <= $radius;
    }

    public function getMinPosition(): Position {
        $radius = floor($this->size / 2);
        return new Position(
            (int)$this->center->x - $radius,
            (int)$this->center->y - $radius,
            (int)$this->center->z - $radius,
            $this->center->getLevel()
        );
    }

    public function getMaxPosition(): Position {
        $radius = floor($this->size / 2);
        return new Position(
            (int)$this->center->x + $radius,
            (int)$this->center->y + $radius,
            (int)$this->center->z + $radius,
            $this->center->getLevel()
        );
    }

    public function getBlockTypeName(): string {
        switch ($this->blockType) {
            case 42: // IRON_BLOCK
                return "Железный блок";
            case 41: // GOLD_BLOCK
                return "Золотой блок";
            case 57: // DIAMOND_BLOCK
                return "Алмазный блок";
            case 133: // EMERALD_BLOCK
                return "Изумрудный блок";
            case 526: // NETHERITE_BLOCK
                return "Незеритовый блок";
            default:
                return "Неизвестный блок";
        }
    }
} 