<?php

namespace Privates\types;

use pocketmine\math\Vector3;

class PrivateArea {

    /** @var string */
    private $id;
    
    /** @var string */
    private $owner;
    
    /** @var Vector3 */
    private $center;
    
    /** @var string */
    private $world;
    
    /** @var int */
    private $size;
    
    /** @var array */
    private $members;
    
    /** @var int */
    private $blockType;

    public function __construct(string $id, string $owner, Vector3 $center, string $world, int $size, array $members, int $blockType) {
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

    public function getCenter(): Vector3 {
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

    public function isInside(Vector3 $position): bool {
        $radius = floor($this->size / 2);
        
        return abs($position->getX() - $this->center->getX()) <= $radius &&
               abs($position->getY() - $this->center->getY()) <= $radius &&
               abs($position->getZ() - $this->center->getZ()) <= $radius;
    }

    public function getMinPosition(): Vector3 {
        $radius = floor($this->size / 2);
        return new Vector3(
            $this->center->getX() - $radius,
            $this->center->getY() - $radius,
            $this->center->getZ() - $radius
        );
    }

    public function getMaxPosition(): Vector3 {
        $radius = floor($this->size / 2);
        return new Vector3(
            $this->center->getX() + $radius,
            $this->center->getY() + $radius,
            $this->center->getZ() + $radius
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
            case 20: // NETHERITE_BLOCK (примерный ID)
                return "Незеритовый блок";
            default:
                return "Неизвестный блок";
        }
    }
} 