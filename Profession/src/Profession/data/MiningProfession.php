<?php

declare(strict_types=1);

namespace Profession\data;

use PlayerData\data\PlayerDataFactory;
use pocketmine\block\BlockIds;
use pocketmine\block\CoalOre;
use pocketmine\block\DiamondOre;
use pocketmine\block\EmeraldOre;
use pocketmine\block\GoldOre;
use pocketmine\block\IronOre;
use pocketmine\block\RedstoneOre;
use pocketmine\event\block\BlockBreakEvent;
use Profession\data\Profession;

class MiningProfession extends Profession {
    public function onBlockBreak(BlockBreakEvent $event): void{
        $player = $event->getPlayer();

        $block = $event->getBlock();

        if ($block instanceof CoalOre || $block instanceof DiamondOre || $block instanceof EmeraldOre || $block instanceof GoldOre || $block instanceof IronOre || $block instanceof RedstoneOre) {
            $level = PlayerDataFactory::getData($player->getLowerCaseName())->getProfessionData()->getLevel();

            if ($level <= 50) {
                if (mt_rand(1, 100) <= $level * 2) {
                    $drops = $event->getDrops();
                    $event->setDrops(array_merge($drops, $drops));
                }
            } else {
                if (mt_rand(1, 100) <= ($level - 50) * 4) {
                    $drops = $event->getDrops();

                    for ($i = 0; $i < 2; $i++) {
                        $drops = array_merge($drops);
                    }

                    $event->setDrops($drops);
                }
            }
        }

        switch ($block->getId()) {
            case BlockIds::STONE:
            case BlockIds::COAL_ORE:
                $this->addEXP($player, 1);
                break;

            case BlockIds::IRON_ORE:
            case BlockIds::GOLD_ORE:
            case BlockIds::LAPIS_ORE:
                $this->addEXP($player, 2);
                break;

            case BlockIds::DIAMOND_ORE:
                $this->addEXP($player, 3);
                break;
        }
    }

    public function getCrackName(): string{
        return '%profession.mining.name%';
    }

    public function calculateFormula(int $currentLevel): float{
        return round(50 * 1.2 ** ($currentLevel), -1);
    }

    public function getMaxLevel(): int{
        return 70;
    }
}