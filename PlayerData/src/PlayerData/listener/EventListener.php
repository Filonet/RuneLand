<?php

declare(strict_types=1);

namespace PlayerData\listener;

use PlayerData\data\PlayerDataFactory;
use PlayerData\event\LoadPlayerDataEvent;
use PlayerData\Language;
use PlayerData\Loader;
use PlayerData\types\SessionIds;
use PlayerData\utils\Utils;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskHandler;

class EventListener implements Listener {

    public array $attempt = [];
    public array $copyPassword = [];
    /** @var TaskHandler[]  */
    public array $auth_timeout = [];
    public function __construct(
        private Loader $loader,
    ){}

    public function onJoin(PlayerJoinEvent $event): void {
        if (($player = $event->getPlayer())->getProtocolVersion() < ProtocolInfo::PROTOCOL_407) {
            $player->close("", Language::translate("%playerdata.dont.support.version%", $player));
        }

        $event->setJoinMessage("");
    }

    public function onPlayerLogin(PlayerLoginEvent $event) : void{
        $player = $event->getPlayer();

        $player->setImmobile();

        Loader::$mThread->pushDataRequestPacket([$player->getLowerCaseName(), $player->getClientId()]);
    }

    public function onDeath(PlayerDeathEvent $event): void {
        $player = $event->getPlayer();

        $event->setDeathMessage("");

        PlayerDataFactory::getData($player->getLowerCaseName())->getStatsData()->addDeaths(1);
        Loader::$mThread->pushQueryPacket('INSERT INTO `stats` (`nickname`, `money`, `runes`, `kills`, `deaths`, `gameTime`) VALUES ("' . $player->getLowerCaseName() . '", 0, 0, 0, 1, 0) ON DUPLICATE KEY UPDATE `deaths` = `deaths` + 1;');

        $cause = $player->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $attacker = $cause->getDamager();
            if ($attacker instanceof Player) {
                PlayerDataFactory::getData($attacker->getLowerCaseName())->getStatsData()->addKills(1);
                Loader::$mThread->pushQueryPacket('INSERT INTO `stats` (`nickname`, `money`, `runes`, `kills`, `deaths`, `gameTime`) VALUES ("' . $attacker->getLowerCaseName() . '", 0, 0, 1, 0, 0) ON DUPLICATE KEY UPDATE `kills` = `kills` + 1;');
            }
        }
    }

    public function onDrop(PlayerDropItemEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
        }
    }

    public function onInteract(PlayerInteractEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
        }
    }

    public function onMove(PlayerMoveEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
        }
    }

    public function onBreak(BlockBreakEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
        }
    }

    public function onPlace(BlockPlaceEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
        }
    }

    public function onChat(PlayerChatEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
        }
    }

    public function onDamage(EntityDamageEvent $event): void{
        if ($event instanceof EntityDamageByEntityEvent) {
            $player = $event->getEntity();
            if ($player instanceof Player) {
                $damager = $event->getDamager();
                if ($damager instanceof Player) {
                    if (
                        (PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage() !== SessionIds::SUCCESS) ||
                        (PlayerDataFactory::getData($damager->getLowerCaseName())->getAuthData()->getStage() !== SessionIds::SUCCESS)
                    ) {
                        $event->setCancelled();
                    }
                }
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event): void{
        $event->setQuitMessage("");

        $player = $event->getPlayer();

        unset($this->attempt[$player->getLowerCaseName()]);
        unset($this->copyPassword[$player->getLowerCaseName()]);

        if (isset($this->auth_timeout[$player->getLowerCaseName()])) {
            $this->auth_timeout[$player->getLowerCaseName()]->cancel();
            unset($this->auth_timeout[$player->getLowerCaseName()]);
        }

        if ($player->hasEffect(15)) {
            $player->removeEffect(15);
        }

        PlayerDataFactory::delData($player->getLowerCaseName());
    }

    /**
     * @priority LOWEST
     */
    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event): void{
        $player = $event->getPlayer();
        $sessionId = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getStage();
        $message = $event->getMessage();
        if ($sessionId !== SessionIds::SUCCESS) {
            $event->setCancelled();
            if (count(explode("/", $message)) > 1) {
                $event->setCancelled();
                return;
            }

            $password = explode(" ", $message)[0];
            if ($sessionId === SessionIds::REGISTER) {
                if (isset($this->copyPassword[$player->getLowerCaseName()])) {
                    $copyPassword = $this->copyPassword[$player->getLowerCaseName()];
                    if ($copyPassword !== $password) {
                        unset($this->copyPassword[$player->getLowerCaseName()]);

                        $player->sendMessage(Language::translate("%playerdata.auth.password.dont.match%", $player));
                        return;
                    }

                    $player->sendMessage(Language::translate("%playerdata.auth.successful%", $player));

                    $player->removeEffect(Effect::BLINDNESS);
                    $player->setImmobile(false);

                    $this->successfulAuth($player);

                    $authData = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData();
                    $authData->setStage(SessionIds::SUCCESS);
                    $authData->setAddress($player->getAddress());

                    Loader::$mThread->pushQueryPacket('INSERT INTO `auth` (`nickname`, `password`, `address`) VALUES("' . $player->getLowerCaseName() . '", "' . Utils::encryptionPassword($password) . '", "' . $player->getAddress() . '") ON DUPLICATE KEY UPDATE `address` = "' . $player->getAddress() . '";');
                } else {
                    if (!preg_match("/^[0-9a-zA-Zа-яА-Я.,!?@#$%^&*_]{6,24}$/", $password)) {
                        $player->sendMessage(Language::translate("%playerdata.auth.incorrect.syntax%", $player));
                        return;
                    }

                    $player->sendMessage(Language::translate("%playerdata.auth.keep.password.more%", $player));

                    $this->copyPassword[$player->getLowerCaseName()] = $password;
                }
            } elseif ($sessionId === SessionIds::LOGIN) {
                $passwordUser = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData()->getPassword();
                if ($passwordUser === Utils::encryptionPassword($password)) {
                    $player->sendMessage(Language::translate("%playerdata.auth.successful%", $player));

                    Loader::$mThread->pushQueryPacket('INSERT INTO `auth` (`nickname`, `password`, `address`) VALUES("' . $player->getLowerCaseName() . '", "' . $password . '", "' . $player->getAddress() . '") ON DUPLICATE KEY UPDATE `address` = "' . $player->getAddress() . '";');

                    $player->removeEffect(Effect::BLINDNESS);
                    $player->setImmobile(false);

                    $this->successfulAuth($player);

                    $authData = PlayerDataFactory::getData($player->getLowerCaseName())->getAuthData();
                    $authData->setStage(SessionIds::SUCCESS);
                    $authData->setAddress($player->getAddress());
                } else {
                    $attempt = $this->attempt[$player->getLowerCaseName()];
                    if ($attempt <= 1) {
                        $player->close("", Language::translate("%playerdata.auth.kick.many.select.password%", $player));

                        unset($this->attempt[$player->getLowerCaseName()]);
                    } else {
                        $attempt--;

                        $player->sendMessage(Language::translate("%playerdata.auth.wrong.password%", $player, [
                            "attempt" => $attempt
                        ]));

                        $this->attempt[$player->getLowerCaseName()] = $attempt;
                    }
                }
            }
        }
    }

    public function onLoadPlayerDataEvent(LoadPlayerDataEvent $event): void{
        if ($event->isCancelled()) return;

        $data = $event->getData();
        $player = $event->getPlayer();

        $player->setImmobile(true);
        $authData = $data->getAuthData();

        if ($player->isConnected()) {
            if ($authData->getAddress() === $player->getAddress()) {
                $authData->setStage(SessionIds::SUCCESS);
                $authData->setAddress($player->getAddress());

                $player->removeEffect(Effect::BLINDNESS);
                $player->setImmobile(false);

                $this->loader->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($player): void {
                    $this->successfulAuth($player);
                }), 10);

                $player->sendMessage(Language::translate("%playerdata.auth.successful%", $player));
            } else {
                if ($authData->getStage() === SessionIds::NONE) {
                    $authData->setStage(SessionIds::REGISTER);
                }

                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), INT32_MAX, 0, false));
                $this->attempt[$player->getLowerCaseName()] = 5;

                $stage = $authData->getStage();
                if ($stage === SessionIds::REGISTER) {
                    $this->setAuthTimer($player);

                    $player->sendMessage(Language::translate("%playerdata.auth.register%", $player));

                    Loader::$mThread->pushQueryClosureInputPacket("SELECT `nickname` FROM `auth` WHERE `nickname` = '" . strtolower($player->getName()) . "';",
                        function (array $result) use ($player) {
                            foreach ($result as $row) {
                                $player->close("", Language::translate("%playerdata.auth.kick.accaount.regesiter.error:%", $player));
                                return;
                            }
                        });
                } elseif ($stage === SessionIds::LOGIN) {
                    $this->setAuthTimer($player);

                    $player->sendMessage(Language::translate("%playerdata.auth.login%", $player));
                } else {
                    $player->kick("Error #1", false);
                }
            }
        }
    }

    public function setAuthTimer(Player $target) :  void{
        $target->addEffect(new EffectInstance(Effect::getEffect(15), 9999999, 4, true));
        $task = $this->loader->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) use ($target): void {
            $target->close("", "Login timeout");
        }), 20 * 75);

        $this->auth_timeout[$target->getLowerCaseName()] = $task;
    }

    public function successfulAuth(Player $player) : void{
        if (isset($this->auth_timeout[$player->getLowerCaseName()])) {
            $this->auth_timeout[$player->getLowerCaseName()]->cancel();
            unset($this->auth_timeout[$player->getLowerCaseName()]);
        }

        if ($player->hasEffect(Effect::BLINDNESS)) {
            $player->removeEffect(Effect::BLINDNESS);
        }
    }
}