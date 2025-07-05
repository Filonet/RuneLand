<?php

namespace Privates\manager;

use pocketmine\block\Block;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\utils\Config;
use Privates\Loader;
use Privates\types\PrivateArea;
use PlayerData\data\PlayerDataFactory;
use PlayerData\types\Group;

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

    /**
     * Получает максимальное количество приватов для игрока в зависимости от его привилегии
     * @param Player $player
     * @return int
     */
    public function getMaxPrivatesForPlayer(Player $player): int {
        $playerData = PlayerDataFactory::getData(strtolower($player->getName()));
        $group = $playerData->getGroupData()->getGroup();
        
        switch ($group) {
            case Group::HERO:
                return 2;
            case Group::HUNTER:
                return 4;
            case Group::RANGER:
                return 12;
            case Group::ELEMENTAL:
                return 20;
            case Group::PHANTOM:
                return 35;
            case Group::ARCANA:
                return 50;
            case Group::TITAN:
                return 100;
            case Group::ELDER:
                return 200; // Предполагаемое количество для ELDER
            default:
                return 1; // Для Group::NONE и неизвестных групп
        }
    }

    public function saveAll(): void {
        $data = [];
        $cleaned = 0;
        
        foreach ($this->privates as $id => $private) {
            // Проверяем, существует ли блок в центре привата (только если мир загружен)
            $server = $this->plugin->getServer();
            if ($server->isLevelLoaded($private->getWorld())) {
                $level = $server->getLevelByName($private->getWorld());
                if ($level !== null) {
                    $center = $private->getCenter();
                    $block = $level->getBlock($center);
                    
                    if (!isset($this->blockSizes[$block->getId()])) {
                        // Блок не является приватным блоком, пропускаем сохранение
                        $cleaned++;
                        continue;
                    }
                }
            }
            
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
        
        if ($cleaned > 0) {
            $this->plugin->getLogger()->info("Автоматически очищено висячих приватов: " . $cleaned);
            // Обновляем массив приватов
            $this->privates = array_filter($this->privates, function($private) {
                $server = $this->plugin->getServer();
                if ($server->isLevelLoaded($private->getWorld())) {
                    $level = $server->getLevelByName($private->getWorld());
                    if ($level !== null) {
                        $center = $private->getCenter();
                        $block = $level->getBlock($center);
                        return isset($this->blockSizes[$block->getId()]);
                    }
                }
                return true; // Сохраняем приваты из незагруженных миров
            });
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
        
        // Проверяем лимит приватов в зависимости от привилегии
        $maxPrivates = $this->getMaxPrivatesForPlayer($player);
        $playerPrivates = count($this->getPrivateByOwner($player->getName()));
        if ($playerPrivates >= $maxPrivates) {
            $player->sendMessage($this->plugin->getMessage("max-privates-reached", ["max" => $maxPrivates]));
            return false;
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

    /**
     * Отправляет игроку информацию о его приватах и лимитах
     * @param Player $player
     */
    public function sendPrivatesInfo(Player $player): void {
        $playerData = PlayerDataFactory::getData(strtolower($player->getName()));
        $group = $playerData->getGroupData()->getGroup();
        $maxPrivates = $this->getMaxPrivatesForPlayer($player);
        $currentPrivates = count($this->getPrivateByOwner($player->getName()));
        
        // Определяем название группы в зависимости от языка
        $langCode = $this->plugin->getConfig()->get("language", "ru_RU");
        switch ($group) {
            case Group::NONE:
                $groupName = $langCode === "en_US" ? "Newbie" : "Новичок";
                break;
            case Group::HERO:
                $groupName = "HERO";
                break;
            case Group::HUNTER:
                $groupName = "HUNTER";
                break;
            case Group::RANGER:
                $groupName = "RANGER";
                break;
            case Group::ELEMENTAL:
                $groupName = "ELEMENTAL";
                break;
            case Group::PHANTOM:
                $groupName = "PHANTOM";
                break;
            case Group::ARCANA:
                $groupName = "ARCANA";
                break;
            case Group::TITAN:
                $groupName = "TITAN";
                break;
            case Group::ELDER:
                $groupName = "ELDER";
                break;
            default:
                $groupName = $langCode === "en_US" ? "Unknown" : "Неизвестно";
                break;
        }
        
        $player->sendMessage($this->plugin->getMessage("privates-count-info", [
            "current" => $currentPrivates,
            "max" => $maxPrivates,
            "group" => $groupName
        ]));
    }
} 