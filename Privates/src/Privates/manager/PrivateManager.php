<?php

namespace Privates\manager;

use pocketmine\block\Block;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\utils\Config;
use Privates\Loader;
use Privates\types\PrivateArea;

class PrivateManager {

    /** @var Loader */
    private $plugin;
    
    /** @var Config */
    private $data;
    
    /** @var PrivateArea[] */
    private $privates = [];
    
    /** @var array */
    private $blockSizes = [
        Block::IRON_BLOCK => 5,      // 5x5x5
        Block::GOLD_BLOCK => 7,      // 7x7x7  
        Block::DIAMOND_BLOCK => 11,  // 11x11x11
        Block::EMERALD_BLOCK => 21,  // 21x21x21
        Block::NETHERITE_BLOCK => 31 // 31x31x31
    ];

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
        $this->data = new Config($plugin->getDataFolder() . "privates.yml", Config::YAML);
        $this->loadBlockSizesFromConfig();
        $this->loadPrivates();
    }

    private function loadBlockSizesFromConfig(): void {
        $config = $this->plugin->getConfig();
        $configSizes = $config->get("block-sizes", []);
        
        $this->blockSizes = [
            Block::IRON_BLOCK => $configSizes["iron"] ?? 5,
            Block::GOLD_BLOCK => $configSizes["gold"] ?? 7,
            Block::DIAMOND_BLOCK => $configSizes["diamond"] ?? 11,
            Block::EMERALD_BLOCK => $configSizes["emerald"] ?? 21,
            Block::NETHERITE_BLOCK => $configSizes["netherite"] ?? 31
        ];
    }

    public function loadPrivates(): void {
        $privates = $this->data->get("privates", []);
        foreach ($privates as $id => $data) {
            $this->privates[$id] = new PrivateArea(
                $id,
                $data["owner"],
                new Position($data["x"], $data["y"], $data["z"], null),
                $data["world"],
                $data["size"],
                $data["members"] ?? [],
                $data["blockType"]
            );
        }
    }

    public function saveAll(): void {
        $data = [];
        foreach ($this->privates as $id => $private) {
            $center = $private->getCenter();
            $data[$id] = [
                "owner" => $private->getOwner(),
                "x" => (int)$center->x,
                "y" => (int)$center->y,
                "z" => (int)$center->z,
                "world" => $private->getWorld(),
                "size" => $private->getSize(),
                "members" => $private->getMembers(),
                "blockType" => $private->getBlockType()
            ];
        }
        $this->data->set("privates", $data);
        $this->data->save();
    }

    public function createPrivate(Player $player, Position $position, string $world, int $blockType): bool {
        if (!isset($this->blockSizes[$blockType])) {
            return false;
        }
        
        // Проверяем, разрешен ли мир
        $allowedWorlds = $this->plugin->getConfig()->get("allowed-worlds", ["world"]);
        $player->sendMessage("§7[DEBUG] Текущий мир: '" . $world . "'");
        $player->sendMessage("§7[DEBUG] Разрешенные миры: " . implode(", ", $allowedWorlds));
        
        // Временно отключаем проверку мира
        // if (!in_array($world, $allowedWorlds)) {
        //     $player->sendMessage($this->plugin->getMessage("world-not-allowed"));
        //     return false;
        // }
        
        // Проверяем лимит приватов
        $maxPrivates = $this->plugin->getConfig()->get("settings.max-privates-per-player", 0);
        if ($maxPrivates > 0) {
            $playerPrivates = count($this->getPrivateByOwner($player->getName()));
            if ($playerPrivates >= $maxPrivates) {
                $player->sendMessage($this->plugin->getMessage("max-privates-reached", ["max" => $maxPrivates]));
                return false;
            }
        }
        
        $size = $this->blockSizes[$blockType];
        
        // Проверяем на пересечения с другими приватами
        if ($this->hasConflict($position, $world, $size)) {
            $player->sendMessage($this->plugin->getMessage("private-conflict"));
            return false;
        }
        
        $id = uniqid();
        $private = new PrivateArea($id, $player->getName(), $position, $world, $size, [], $blockType);
        $this->privates[$id] = $private;
        
        $player->sendMessage($this->plugin->getMessage("private-created", [
            "size" => $size . "x" . $size . "x" . $size
        ]));
        
        return true;
    }

    public function removePrivate(string $id): bool {
        if (isset($this->privates[$id])) {
            unset($this->privates[$id]);
            return true;
        }
        return false;
    }

    public function getPrivateAt(Position $position, string $world): ?PrivateArea {
        foreach ($this->privates as $private) {
            if ($private->getWorld() === $world && $private->isInside($position)) {
                return $private;
            }
        }
        return null;
    }

    public function getPrivateByOwner(string $owner): array {
        $result = [];
        foreach ($this->privates as $private) {
            if ($private->getOwner() === $owner) {
                $result[] = $private;
            }
        }
        return $result;
    }

    public function hasConflict(Position $position, string $world, int $size): bool {
        $radius = floor($size / 2);
        
        foreach ($this->privates as $private) {
            if ($private->getWorld() !== $world) continue;
            
            $distance = $position->distance($private->getCenter());
            $minDistance = $radius + floor($private->getSize() / 2);
            
            if ($distance < $minDistance) {
                return true;
            }
        }
        return false;
    }

    public function canBuild(Player $player, Position $position, string $world): bool {
        $private = $this->getPrivateAt($position, $world);
        if ($private === null) {
            return true;
        }
        
        return $private->getOwner() === $player->getName() || 
               in_array($player->getName(), $private->getMembers()) ||
               $player->hasPermission("privates.admin");
    }

    public function getBlockSizes(): array {
        return $this->blockSizes;
    }

    public function getAllPrivates(): array {
        return $this->privates;
    }
} 