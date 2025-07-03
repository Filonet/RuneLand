<?php

declare(strict_types=1);

namespace Kits\listener;

use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\ShulkerBoxInventory;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\item\Item;
use pocketmine\nbt\tag\ByteTag;

class EventListener implements Listener {

    public function onTransaction(InventoryTransactionEvent $event): void {
        $transaction = $event->getTransaction();
        if ($transaction instanceof InventoryTransaction) {
            foreach ($transaction->getActions() as $action) {
                if ($action instanceof SlotChangeAction) {
                    $inventory = $action->getInventory();
                    if ($inventory instanceof ShulkerBoxInventory) {
                        $event->setCancelled();
                        return;
                    }
                }

                if ($action->getSourceItem()->getNamedTag()->hasTag("blocked", ByteTag::class)) {
                    $event->setCancelled();
                    return;
                }

                if ($action->getTargetItem()->getNamedTag()->hasTag("blocked", ByteTag::class)) {
                    $event->setCancelled();
                    return;
                }
            }
        }
    }
}