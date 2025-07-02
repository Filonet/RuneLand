<?php

declare(strict_types=1);

namespace Kits\manager;

use Kits\types\Settings;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\level\format\SubChunk;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\ShulkerBox;
use pocketmine\tile\Tile;

class Manager {

    /** @var Item[][]  */
    private array $kits = [];
    
    public function __construct(
        private Level $level
    ){
        //NOOP
    }
    
    public function spawnShulkers() : void {
        foreach (Settings::KITS2 as $key => $kit) {
            if (isset($kit["shulker"])){
                $positionData = $kit["shulker"];
                $position = new Vector3($positionData[0], $positionData[1], $positionData[2]);
                $isChunk = $this->level->loadChunk($position->getFloorX() >> SubChunk::COORD_BIT_SIZE, $position->getFloorZ() >> SubChunk::COORD_BIT_SIZE);
                if (!$isChunk) {
                    \GlobalLogger::get()->notice("Chunk kit $key dont load");
                    continue;
                }

                $tile = $this->level->getTile($position);
                if (!$tile instanceof ShulkerBox) {
                    \GlobalLogger::get()->notice("Dont found tile $key");
                    return;
                }

                $items = [];
                foreach ($kit["items"] as $slot => $itemData) {
                    $id = (int) $itemData["id"];
                    $meta = (int) ($itemData["meta"] ?? 0);
                    $count = (int)  ($itemData["count"] ?? 1);
                    $enchants = $itemData["enchant"] ?? [];
                    $name = $itemData["name"] ?? null;

                    $item = ItemFactory::get($id, $meta, $count);
                    $item->getNamedTag()->setByte("blocked", 1);

                    if ($name !== null) {
                        $item->setCustomName($name);
                    }

                    foreach ($enchants as $id => $level) {
                        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($id), $level));
                    }

                    $items[$slot] = $item;
                }

                $this->kits[$key] = $items;

                $tile->getInventory()->setContents($items);
            }
        }
    }

    public function giveKit(Player $player, int $kitId) : void {
        if (!isset($this->kits[$kitId])) {
            return;
        }

        $inventory = $player->getInventory();
        foreach ($this->kits[$kitId] as $item) {
            if ($inventory->canAddItem($item)) {
                $inventory->addItem($item);
            } else {
                $player->dropItem($item);
            }
        }
    }
}