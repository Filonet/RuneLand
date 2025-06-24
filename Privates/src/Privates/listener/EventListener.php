<?php

namespace Privates\listener;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBurnEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\block\Block;
use pocketmine\Player;
use Privates\Loader;

class EventListener implements Listener {

    /** @var Loader */
    private $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function onBlockPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $position = $block->asPosition();
        $world = $position->getLevel()->getFolderName();

        // Проверяем, можно ли строить в этом месте
        if (!$this->plugin->getPrivateManager()->canBuild($player, $position, $world)) {
            $event->setCancelled();
            $player->sendMessage($this->plugin->getMessage("no-build-permission"));
            return;
        }

        // Проверяем, является ли блок приватным блоком
        $blockSizes = $this->plugin->getPrivateManager()->getBlockSizes();
        if (isset($blockSizes[$block->getId()])) {
            // Создаем приват
            if ($this->plugin->getPrivateManager()->createPrivate($player, $position, $world, $block->getId())) {
                $size = $blockSizes[$block->getId()];
                $blockName = $this->getBlockName($block->getId());
                $player->sendMessage($this->plugin->getMessage("private-created-detailed", [
                    "block" => $blockName,
                    "size" => $size . "x" . $size . "x" . $size
                ]));
            }
        }
    }

    public function onBlockBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $position = $block->asPosition();
        $world = $position->getLevel()->getFolderName();

        // Проверяем, можно ли ломать в этом месте
        if (!$this->plugin->getPrivateManager()->canBuild($player, $position, $world)) {
            $event->setCancelled();
            $player->sendMessage($this->plugin->getMessage("no-break-permission"));
            return;
        }

        // Проверяем, является ли блок центром привата и может ли игрок его сломать
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private !== null) {
            $blockSizes = $this->plugin->getPrivateManager()->getBlockSizes();
            if (isset($blockSizes[$block->getId()]) && 
                $private->getCenter()->equals($position)) {
                
                // Это центральный блок привата
                if ($private->getOwner() === $player->getName() || $player->hasPermission("privates.break")) {
                    $this->plugin->getPrivateManager()->removePrivate($private->getId());
                    $player->sendMessage($this->plugin->getMessage("private-removed"));
                } else {
                    $event->setCancelled();
                    $player->sendMessage($this->plugin->getMessage("no-break-private-permission"));
                }
            }
        }
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $position = $block->asPosition();
        $world = $position->getLevel()->getFolderName();

        // Проверяем взаимодействие с блоками в приватах
        if (!$this->plugin->getPrivateManager()->canBuild($player, $position, $world)) {
            // Позволяем взаимодействие только с определенными блоками
            $allowedBlocks = [
                Block::CHEST,
                Block::TRAPPED_CHEST,
                Block::FURNACE,
                Block::BURNING_FURNACE,
                Block::CRAFTING_TABLE,
                Block::ANVIL,
                Block::BREWING_STAND_BLOCK,
                Block::ENCHANTING_TABLE
            ];

            if (!in_array($block->getId(), $allowedBlocks)) {
                $event->setCancelled();
                $player->sendMessage($this->plugin->getMessage("no-interact-permission"));
            }
        }
    }

    public function onEntityExplode(EntityExplodeEvent $event): void {
        if (!$this->plugin->getConfig()->get("settings.protect-from-explosions", true)) {
            return;
        }

        $blockList = $event->getBlockList();
        foreach ($blockList as $key => $block) {
            $position = $block->asPosition();
            $world = $position->getLevel()->getFolderName();
            
            $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
            if ($private !== null) {
                unset($blockList[$key]);
            }
        }
        $event->setBlockList($blockList);
    }

    public function onBlockBurn(BlockBurnEvent $event): void {
        if (!$this->plugin->getConfig()->get("settings.protect-from-fire", true)) {
            return;
        }

        $block = $event->getBlock();
        $position = $block->asPosition();
        $world = $position->getLevel()->getFolderName();
        
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private !== null) {
            $event->setCancelled();
        }
    }

    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event): void {
        if (!$this->plugin->getConfig()->get("settings.allow-pvp-in-privates", false)) {
            $victim = $event->getEntity();
            $attacker = $event->getDamager();
            
            if ($victim instanceof Player && $attacker instanceof Player) {
                $position = $victim->asPosition();
                $world = $position->getLevel()->getFolderName();
                
                $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
                if ($private !== null) {
                    $event->setCancelled();
                    $attacker->sendMessage($this->plugin->getMessage("no-pvp-in-private"));
                }
            }
        }
    }

    private function getBlockName(int $blockId): string {
        switch ($blockId) {
            case Block::IRON_BLOCK:
                return "Железный блок";
            case Block::GOLD_BLOCK:
                return "Золотой блок";
            case Block::DIAMOND_BLOCK:
                return "Алмазный блок";
            case Block::EMERALD_BLOCK:
                return "Изумрудный блок";
            case Block::NETHERITE_BLOCK:
                return "Незеритовый блок";
            default:
                return "Неизвестный блок";
        }
    }
} 