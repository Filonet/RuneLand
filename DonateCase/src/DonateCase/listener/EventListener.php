<?php

declare(strict_types=1);

namespace DonateCase\listener;

use DonateCase\Loader;
use DonateCase\task\AnimateCaseTask;
use DonateCase\types\AnimateItem;
use DonateCase\types\Settings;
use PlayerData\data\PlayerDataFactory;
use PlayerData\Language;
use PlayerData\types\Group;
use PlayerData\types\SessionIds;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;

class EventListener implements Listener {

    public ?string $playerOpened = null;

    public FloatingTextParticle $open;
    public FloatingTextParticle $description;
    public FloatingTextParticle $site;

    public function __construct(
        private Loader $loader
    ){
        $this->open = new FloatingTextParticle(new Vector3(Settings::CHEST_X + 0.5, Settings::CHEST_Y + 1.7, Settings::CHEST_Z + 0.5), '', '');
        $this->description = new FloatingTextParticle(new Vector3(Settings::CHEST_X + 0.5, Settings::CHEST_Y + 1.4, Settings::CHEST_Z + 0.5), '', '');
        $this->site = new FloatingTextParticle(new Vector3(Settings::CHEST_X + 0.5, Settings::CHEST_Y + 1.1, Settings::CHEST_Z + 0.5), '', '');
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();

        $this->open->setTitle(Language::translate("%donatecase.floating.name%", $player));
        $this->description->setTitle(Language::translate("%donatecase.floating.description%", $player));
        $this->site->setTitle(Language::translate("%donatecase.floating.site%", $player));

        $player->getServer()->getDefaultLevel()->addParticle($this->open, [$player]);
        $player->getServer()->getDefaultLevel()->addParticle($this->description, [$player]);
        $player->getServer()->getDefaultLevel()->addParticle($this->site, [$player]);
    }

    public function onTap(PlayerInteractEvent $event) : void{
        $block = $event->getBlock();
        $player = $event->getPlayer();

        if (
            $block->getX() == Settings::CHEST_X &&
            $block->getY() == Settings::CHEST_Y &&
            $block->getZ() == Settings::CHEST_Z
        ) {
            $event->setCancelled();

            if (PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage() !== SessionIds::SUCCESS) {
                return;
            }

            if ($this->playerOpened !== null) {
                if ($this->playerOpened !== $player->getLowerCaseName()) {
                    $player->sendPopup(Language::translate("%donatecase.already.opens%", $player, [
                        "nickname" => $this->playerOpened
                    ]));
                } else {
                    $player->sendPopup(Language::translate("%donatecase.you.open%", $player));
                }

            } else {
                if (($count = PlayerDataFactory::getData($player->getLowerCaseName())->getDonateCases()) >= 1) {
                    PlayerDataFactory::getData($player->getLowerCaseName())->setDonateCases($count - 1);

                    \PlayerData\Loader::$mThread->pushQueryPacket('INSERT INTO `donatecase` (`nickname`, `count`) VALUES("' . $player->getLowerCaseName() . '", 0) ON DUPLICATE KEY UPDATE `count` = `count` - 1;');

                    foreach ($player->getServer()->getOnlinePlayers() as $target) {
                        $target->sendMessage(Language::translate("%donatecase.started.open%", $target, [
                            "nickname" => $player->getName()
                        ]));
                    }

                    $this->playerOpened = $player->getLowerCaseName();

                    $this->open->setInvisible(true);
                    $player->getServer()->getDefaultLevel()->addParticle($this->open);
                    $this->description->setInvisible(true);
                    $player->getServer()->getDefaultLevel()->addParticle($this->description);
                    $this->site->setInvisible(true);
                    $player->getServer()->getDefaultLevel()->addParticle($this->site);

                    $this->open($player, $block, 0);
                } else {
                    $player->sendPopup(Language::translate("%donatecase.dont.cases%", $player));
                }
            }
        }
    }

    private function open(Player $player, Block $block, int $count): void {
        $count++;

        $nickname = $player->getLowerCaseName();

        $this->loader->getScheduler()->scheduleRepeatingTask(new AnimateCaseTask($block->getLevel(), $block->add(0.5, 0, 0.5),
            30,
            [
                new AnimateItem("§l§eRUNES " . ($money = mt_rand(1, 100)) . " §r", ItemFactory::get(Item::BLUE_GLAZED_TERRACOTTA), "addrunes $nickname " . $money, 2000),
                new AnimateItem("§l§eMONEY " . ($money = mt_rand(10000, 100000)) . " §r", ItemFactory::get(Item::DOUBLE_PLANT), "addmoney $nickname " . $money, 2000),
                new AnimateItem("§o§9§lHERO§r", ItemFactory::get(Item::CARROT), "givegroup $nickname Hero", 3605),
                new AnimateItem("§o§c§lHUNTER§r", ItemFactory::get(Item::ENDER_EYE), "givegroup $nickname hunter", 1608),
                new AnimateItem("§o§d§lRANGER§r", ItemFactory::get(Item::BLAZE_POWDER), "givegroup $nickname ranger", 400),
                new AnimateItem("§o§b§lELEMENTAL§r", ItemFactory::get(Item::GOLDEN_APPLE), "givegroup $nickname elemental", 157),
                new AnimateItem("§o§e§lPHANTOM§r", ItemFactory::get(Item::MAGMA_CREAM), "givegroup $nickname phantom", 89),
                new AnimateItem("§o§6§lARCANA§r", ItemFactory::get(Item::BLAZE_ROD), "givegroup $nickname arcana", 68),
                new AnimateItem("§o§a§lTITAN§r", ItemFactory::get(Item::FIREBALL), "givegroup $nickname titan", 40),
                new AnimateItem("§o§4§lELDER§r", ItemFactory::get(Item::RABBIT_STEW), "givegroup $nickname elder", 22),
            ],
            function (AnimateItem $animateItem) use ($player, $count): void {
                $this->open->setInvisible(false);

                foreach ($player->getServer()->getOnlinePlayers() as $target) {
                    $target->sendMessage(Language::translate("%donatecase.drop.item%", $target, [
                        "count" => $count,
                        "nickname" => $player->getName(),
                        "item" => $animateItem->getName()
                    ]));

                    $this->open->setTitle(Language::translate("%donatecase.drop.floating%", $target, [
                        "count" => $count,
                        "nickname" => $player->getName(),
                        "item" => $animateItem->getName()
                    ]));

                    $player->getServer()->getDefaultLevel()->addParticle($this->open, [$target]);
                }
            },
            function () use ($player, $block, $count): void {
                if ($count <= 7) {
                    if ($count === 1 || $count === 2) {
                        $this->open($player, $block, $count);
                        return;
                    } elseif (mt_rand(0, 2) === 2) {
                        $this->open($player, $block, $count);
                        return;
                    }
                }

                $this->description->setInvisible(false);
                $this->site->setInvisible(false);

                foreach ($player->getServer()->getOnlinePlayers() as $target) {
                    $target->sendMessage(Language::translate("%donatecase.drop.final%", $target, [
                        "nickname" => $player->getName(),
                        "count" => $count
                    ]));

                    $this->open->setTitle(Language::translate("%donatecase.floating.name%", $target));
                    $this->description->setTitle(Language::translate("%donatecase.floating.description%", $target));
                    $this->site->setTitle(Language::translate("%donatecase.floating.site%", $target));

                    $player->getServer()->getDefaultLevel()->addParticle($this->open, [$target]);
                    $player->getServer()->getDefaultLevel()->addParticle($this->description, [$target]);
                    $player->getServer()->getDefaultLevel()->addParticle($this->site, [$target]);
                }

                $this->playerOpened = null;
            }), 2);
    }
}