<?php

namespace Privates;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\scheduler\ClosureTask;
use Privates\listener\EventListener;
use Privates\manager\PrivateManager;
use Privates\command\AdminPrivatesCommand;
use Privates\command\PrivatesCommand;


class Loader extends PluginBase {

    /** @var Config */
    private $lang;
    
    /** @var PrivateManager */
    private $privateManager;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->saveResource("lang/ru_RU.yml");
        $this->saveResource("lang/en_US.yml");
        
        $this->lang = new Config($this->getDataFolder() . "lang/ru_RU.yml", Config::YAML);
        $this->privateManager = new PrivateManager($this);
        
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("adminprivates", new AdminPrivatesCommand($this));
        $this->getServer()->getCommandMap()->register("privates", new PrivatesCommand($this));
        
        // Запускаем автосохранение
        $this->startAutoSave();
        
        // Проверяем наличие FormAPI
        $formAPI = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if ($formAPI !== null) {
            $this->getLogger()->info("§aFormAPI найден! Будут использоваться графические формы.");
        } else {
            $this->getLogger()->warning("§eFormAPI не найден! Управление через команды в чате.");
        }
        
        $this->getLogger()->info("§aПлагин приватов успешно загружен!");
    }

    public function onDisable(): void {
        $this->privateManager->saveAll();
        $this->getLogger()->info("§cПлагин приватов выгружен!");
    }

    public function getLang(): Config {
        return $this->lang;
    }

    public function getPrivateManager(): PrivateManager {
        return $this->privateManager;
    }

    public function getMessage(string $key, array $params = []): string {
        $message = $this->lang->get($key, $key);
        foreach ($params as $param => $value) {
            $message = str_replace("{" . $param . "}", $value, $message);
        }
        return $message;
    }

    private function startAutoSave(): void {
        $interval = $this->getConfig()->get("settings.auto-save-interval", 300);
        
        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
            $this->privateManager->saveAll();
            if ($this->getConfig()->get("debug", false)) {
                $this->getLogger()->info("§7Приваты автоматически сохранены");
            }
        }), $interval * 20); // Переводим секунды в тики
    }
} 