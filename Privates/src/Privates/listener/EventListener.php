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
use pocketmine\form\MenuForm;
use pocketmine\form\ModalForm;
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

        $player->sendMessage("§7[DEBUG] Поставлен блок ID: " . $block->getId());
        
        // Проверяем, является ли блок приватным блоком
        $blockSizes = $this->plugin->getPrivateManager()->getBlockSizes();
        $player->sendMessage("§7[DEBUG] Доступные блоки: " . implode(", ", array_keys($blockSizes)));
        
        if (isset($blockSizes[$block->getId()])) {
            $player->sendMessage("§7[DEBUG] Это приватный блок!");
            // Создаем приват
            if ($this->plugin->getPrivateManager()->createPrivate($player, $position, $world, $block->getId())) {
                $size = $blockSizes[$block->getId()];
                $blockName = $this->getBlockName($block->getId());
                $player->sendMessage("§aВы создали приват из блока '" . $blockName . "' размером " . $size . "x" . $size . "x" . $size . "!");
            } else {
                $player->sendMessage("§cНе удалось создать приват!");
            }
            return;
        }

        // Проверяем, можно ли строить в этом месте
        if (!$this->plugin->getPrivateManager()->canBuild($player, $position, $world)) {
            $event->setCancelled();
            $player->sendMessage($this->plugin->getMessage("no-build-permission"));
            return;
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

        // Проверяем, является ли этот блок центром привата
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private !== null) {
            $blockSizes = $this->plugin->getPrivateManager()->getBlockSizes();
            if (isset($blockSizes[$block->getId()]) && 
                $private->getCenter()->equals($position)) {
                
                // Это центральный блок привата
                if ($private->getOwner() === $player->getName()) {
                    // Открываем форму управления приватом
                    $this->openPrivateManagementForm($player, $private);
                    $event->setCancelled();
                    return;
                } else {
                    $player->sendMessage("§eИнформация о привате:");
                    $player->sendMessage("§6Владелец: §f" . $private->getOwner());
                    $player->sendMessage("§6Размер: §f" . $private->getSize() . "x" . $private->getSize() . "x" . $private->getSize());
                    $player->sendMessage("§6Тип блока: §f" . $private->getBlockTypeName());
                    $event->setCancelled();
                    return;
                }
            }
        }

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

    private function openPrivateManagementForm(Player $player, $private): void {
        // Показываем меню через сообщения
        $player->sendMessage("§e=== Управление приватом ===");
        $player->sendMessage("§6Используйте команды для управления:");
        $player->sendMessage("§f/pv info §7- Информация о привате");
        $player->sendMessage("§f/pv add <игрок> §7- Добавить участника");
        $player->sendMessage("§f/pv remove <игрок> §7- Удалить участника");
        $player->sendMessage("§f/pv members §7- Список участников");
        $player->sendMessage("§f/pv delete §7- Удалить приват");
    }

    private function showPrivateInfo(Player $player, $private): void {
        $player->sendMessage("§e=== Информация о привате ===");
        $player->sendMessage("§6Владелец: §f" . $private->getOwner());
        $player->sendMessage("§6Размер: §f" . $private->getSize() . "x" . $private->getSize() . "x" . $private->getSize());
        $player->sendMessage("§6Тип блока: §f" . $private->getBlockTypeName());
        $player->sendMessage("§6Участников: §f" . count($private->getMembers()));
        $player->sendMessage("§6Центр: §f" . (int)$private->getCenter()->x . ", " . (int)$private->getCenter()->y . ", " . (int)$private->getCenter()->z);
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