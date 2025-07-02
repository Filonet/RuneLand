<?php

declare(strict_types=1);

namespace Groups\listener;

use Groups\helper\GroupHelper;
use Groups\Loader;
use Groups\types\Settings;
use Groups\utils\Utils;
use PlayerData\data\GroupData;
use PlayerData\data\PlayerDataFactory;
use PlayerData\event\LoadPlayerDataEvent;
use PlayerData\types\Group;
use PlayerData\types\SessionIds;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\utils\TextFormat;

class EventListener implements Listener {

    private array $player_warns = [];
    private array $last_messages = [];
    private array $warn_count = [];
    private array $drop = [];
    private array $cooldown = [];

    public function __construct(){
        //NOOP
    }

    public function onLoadPlayerDataEvent(LoadPlayerDataEvent $event): void{
        if ($event->isCancelled()) return;

        $player = $event->getPlayer();

        $data = $event->getData();
        $groupData = $data->getGroupData();
        $expirationGroup = $groupData->getExpirationGroup();
        if ($expirationGroup !== 0 && $expirationGroup < time()) {
            $groupData->setGroup(Group::NONE);
            $groupData->setExpirationGroup(0);

            $player->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $player->getLowerCaseName() . " " . Group::NONE);
        }

        GroupHelper::updateTags($player);
    }

    public function onChat(PlayerChatEvent $event): void{
        if ($event->isCancelled()) {
            return;
        }

        $player = $event->getPlayer();
        $message = $event->getMessage();

        if (Utils::hasAdvertisement($message)) {
            if (!isset($this->player_warns[$client_id = $player->getClientId()])) {
                $this->player_warns[$client_id] = 1;
            } else {
                ++$this->player_warns[$client_id];
            }

            if ($this->player_warns[$client_id] >= 5) {
                $player->close('', 'Anti-spam');
            }

            $event->setCancelled();
            return;
        }

        $message = Utils::checkString(Utils::filterString(TextFormat::clean($message), true, true));

        if (str_replace(' ', '', ($target_message = substr($message, 1))) === '') {
            $event->setCancelled();
            return;
        }

        $event->setMessage($message);

        $event->setCancelled(true);

        $text = null;
        if (($message[0] ?? '') === '!') {
            foreach ($player->getServer()->getOnlinePlayers() as $pls) {
                $authed = false;
                if (PlayerDataFactory::getData($pls->getLowerCaseName())->getAuthData()->getStage() === SessionIds::SUCCESS) {
                    $authed = true;
                }

                if ($authed) {
                    if ($target_message[0] == ' ') {
                        $pls->sendMessage($text = '§6G §7| ' . GroupHelper::getChat($player, substr($target_message, 1)));
                    } else {
                        $pls->sendMessage($text = '§6G §7| ' . GroupHelper::getChat($player, $target_message));
                    }
                }
            }
        } else {
            foreach ($player->getServer()->getOnlinePlayers() as $pls) {
                if ($pls->getPosition()->distance($player->getPosition()) <= 100) {
                    $authed = false;
                    if (PlayerDataFactory::getData($pls->getLowerCaseName())->getAuthData()->getStage() === SessionIds::SUCCESS) {
                        $authed = true;
                    }

                    if ($authed) {
                        $pls->sendMessage($text = '§bL §7| ' . GroupHelper::getChat($player, $message));
                    }
                }
            }
        }

        if ($text !== null) {
            $player->getServer()->getLogger()->info($text);
        }

        if (!isset($this->last_messages[$player->getId()])) {
            $this->last_messages[$player->getId()] = [
                "messages" => [$event->getMessage()],
                "time" => time() + 10
            ];
        } else {
            $this->last_messages[$player_id = $player->getId()]["messages"][] = $event->getMessage();

            if (time() <= $this->last_messages[$player_id]["time"]) {
                return;
            }

            $count_messages = count($this->last_messages[$player_id]["messages"]);

            if ($count_messages <= 2) {
                unset($this->last_messages[$player_id]);
                return;
            }

            $warning = 0;

            for ($first = 0; $first <= $count_messages; ++$first) {

                $second = $first + 1;

                if (!isset($this->last_messages[$player_id]["messages"][$first], $this->last_messages[$player_id]["messages"][$second])) {
                    continue;
                }

                similar_text($this->last_messages[$player_id]["messages"][$first], $this->last_messages[$player_id]["messages"][$second], $perc);

                if ($perc >= 90) {
                    ++$warning;
                }
            }

            if ($warning > 2) {
                $player->close('',  'Anti-spam');
            }

            unset($this->last_messages[$player_id]);
        }
    }

    public function onPreProcess(PlayerCommandPreprocessEvent $event) : void{
        $player = $event->getPlayer();
        $nickname = $player->getLowerCaseName();

        if (!isset($this->warn_count[$nickname])) {
            $this->warn_count[$nickname] = 0;
        }

        if ($this->warn_count[$nickname] > 3) {
            $player->close('', "Anti-spam");

            unset($this->warn_count[$nickname], $this->drop[$nickname], $this->cooldown[$nickname]);

            $event->setCancelled();
            return;
        }

        if (isset($this->cooldown[$nickname])) {
            if ((time() - $this->cooldown[$nickname]) <= 1) {
                $this->warn_count[$nickname]++;
                $this->drop[$nickname] = time();

                $event->setCancelled();
                return;
            }
        }

        if (isset($this->drop[$nickname])) {
            if ((time() - $this->drop[$nickname]) > 600) {
                unset($this->warn_count[$nickname], $this->drop[$nickname]);
            }
        }

        $this->cooldown[$nickname] = time();
    }
}