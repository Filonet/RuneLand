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
    /** @var Vector3[]  */
    private array $shulkers = [];
    
    public function __construct(
        private Level $level
    ){
        foreach (Settings::KITS as $kitName => $kit) {
            if (isset($kit["shulker"])) {
                $shulkerPosition = $kit["shulker"];
                $position = new Vector3($shulkerPosition[0], $shulkerPosition[1], $shulkerPosition[2]);
                $this->shulkers[$kitName] = $position;
            }

            $items = [];
            foreach ($kit["items"] as $slot => $itemData) {
                $id = (int)$itemData["id"];
                $meta = (int)($itemData["meta"] ?? 0);
                $count = (int)($itemData["count"] ?? 1);
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

            $this->kits[$kitName] = $items;
        }
    }
    
    public function spawnShulkers() : void {
        foreach (Settings::KITS as $kitName => $kit) {
            if (isset($kit["shulker"])){
                $shulkerPosition = $kit["shulker"];
                $position = new Vector3($shulkerPosition[0], $shulkerPosition[1], $shulkerPosition[2]);
                $isChunk = $this->level->loadChunk($position->getFloorX() >> SubChunk::COORD_BIT_SIZE, $position->getFloorZ() >> SubChunk::COORD_BIT_SIZE);
                if (!$isChunk) {
                    \GlobalLogger::get()->notice("Chunk kit $kitName dont load");
                    continue;
                }

                $tile = $this->level->getTile($position);
                if (!$tile instanceof ShulkerBox) {
                    \GlobalLogger::get()->notice("Dont found tile $kitName");
                    return;
                }

                $tile->getInventory()->setContents($this->kits[$kitName]);
            }
        }
    }

    public function isPositionShulker(Vector3 $position) : bool {
        foreach ($this->shulkers as $kitName => $shulkerPosition) {
            if ($position->floor()->equals($shulkerPosition->floor())) {
                return true;
            }
        }

        return false;
    }

    public function giveKit(Player $player, string $kitName) : void {
        if (!isset($this->kits[$kitName])) {
            return;
        }

        $inventory = $player->getInventory();
        foreach ($this->kits[$kitName] as $item) {
            if ($inventory->canAddItem($item)) {
                $inventory->addItem($item);
            } else {
                $player->dropItem($item);
            }
        }
    }
}