<?php

declare(strict_types=1);

namespace DonateCase\types;

use pocketmine\item\Item;

class AnimateItem {
    public function __construct(
        private string $name,
        private Item $item,
        private string $command,
        private int $chance,
    ){}

    public function getName(): string {
        return $this->name;
    }

    public function getItem(): Item {
        return $this->item;
    }

    public function getCommand(): string {
        return $this->command;
    }

    public function getChance(): int {
        return $this->chance;
    }
}