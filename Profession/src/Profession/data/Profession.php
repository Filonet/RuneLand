<?php

declare(strict_types=1);

namespace Profession\data;

use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\level\particle\LavaParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

abstract class Profession {

    public function onBlockBreak(BlockBreakEvent $event) : void{

    }

    public function onBlockPlace(BlockPlaceEvent $event) : void{

    }

    abstract public function getCrackName(): string;

    abstract public function calculateFormula(int $currentLevel): float;

    abstract public function getMaxLevel(): int;

    protected function addEXP(Player $player, int $exp) : void {
        $professionData = PlayerDataFactory::getData($player->getLowerCaseName())->getProfessionData();

        if ($professionData->getLevel() >= $this->getMaxLevel()) { var_dump(1);
            return;
        }

        $professionData->addExperience($exp);

        $max = $this->calculateFormula($professionData->getLevel());
        $have = $professionData->getExperience();
        $player->sendPopup(Language::translate($this->getCrackName(), $player) ."§f Lvl: §6" . $professionData->getLevel() . PHP_EOL . $this->generateProgressBar($max, $have));

        if ($have >= $max) {
            $professionData->setExperience((int) ($have - $max));
            $professionData->addLevel(1);

            $center = $player->getPosition();
            $size = 4;
            $count = 20;
            $particle = new LavaParticle($center);

            for ($yaw = 0, $y = $center->y; $y < $center->y + $size; $yaw += (M_PI * 2) / 100, $y += 1 / $count) {
                $x = -sin($yaw) + $center->x;
                $z = cos($yaw) + $center->z;
                $particle->x = $x;
                $particle->y = $y;
                $particle->z = $z;
                $center->getLevel()->addParticle($particle);
            }

            $volume = 0x10000000 * (min(30, $professionData->getLevel()) / 5); //No idea why such odd numbers, but this works...
            $player->level->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_LEVELUP, (int) $volume);

            $player->sendTitle(
                Language::translate("%profession.levelUp.title%", $player),
                Language::translate("%profession.levelUp.subtitle%", $player, [
                    "profession" => Language::translate($this->getCrackName(), $player),
                    "level" => $professionData->getLevel()
                ]),
                10, 10, 10
            );
        }

        \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `profession` (`nickname`, `level`, `experience`) VALUES("' . $player->getLowerCaseName() . '", "' . $professionData->getLevel() . '", "' . $professionData->getExperience() . '") ON DUPLICATE KEY UPDATE `level` = "' . $professionData->getLevel() . '", `experience` = "' . (int) $professionData->getExperience() . '";');
    }

    public function generateProgressBar($max, $have): string{
        $totalTicks = 12;
        $greenTicks = round(($have / $max) * $totalTicks);
        $yellowTicks = max(($totalTicks - $greenTicks), 0);

        $greenTicksStr = str_repeat("|", (int)$greenTicks);
        $yellowTicksStr = str_repeat("|", (int) $yellowTicks);

        return '§7[§a' . $greenTicksStr . '§e' .  $yellowTicksStr . '§7]';
    }
}