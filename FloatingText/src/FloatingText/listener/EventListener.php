<?php

declare(strict_types=1);

namespace FloatingText\listener;

use FloatingText\Loader;
use FloatingText\types\Settings;
use PlayerData\event\LoadPlayerDataEvent;
use PlayerData\Language;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\scheduler\ClosureTask;

class EventListener implements Listener {
    private Level $level;

    public function __construct(
        private Loader $loader
    ){
        $this->level = $loader->getServer()->getDefaultLevel(); //мир лобби
    }

    public function onLoad(LoadPlayerDataEvent $event) : void {
        $player = $event->getPlayer();
        $this->loader->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($player) : void {
            foreach (Settings::FLOATING_TEXTS as [$x, $y, $z, $text]) {
                $this->level->addParticle(new FloatingTextParticle(new Vector3($x, $y, $z), "", Language::translate($text, $player)), [$player]);
            }
        }), 40);
    }
}