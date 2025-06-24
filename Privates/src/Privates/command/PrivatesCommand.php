<?php

namespace Privates\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Privates\Loader;

class PrivatesCommand extends Command {

    /** @var Loader */
    private $plugin;

    public function __construct(Loader $plugin) {
        parent::__construct("privates", "Команды управления приватами", "/privates <subcommand>", ["private", "pv"]);
        $this->plugin = $plugin;
        $this->setPermission("privates.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cЭта команда доступна только игрокам!");
            return false;
        }

        if (!$this->testPermission($sender)) {
            return false;
        }

        if (empty($args)) {
            $this->sendHelp($sender);
            return true;
        }

        switch (strtolower($args[0])) {
            case "info":
                $this->handleInfo($sender);
                break;
            case "list":
                $this->handleList($sender);
                break;
            case "add":
                if (isset($args[1])) {
                    $this->handleAddMember($sender, $args[1]);
                } else {
                    $sender->sendMessage("§cИспользование: /privates add <игрок>");
                }
                break;
            case "remove":
                if (isset($args[1])) {
                    $this->handleRemoveMember($sender, $args[1]);
                } else {
                    $sender->sendMessage("§cИспользование: /privates remove <игрок>");
                }
                break;
            case "delete":
                $this->handleDelete($sender);
                break;
            case "members":
                $this->handleMembers($sender);
                break;
            case "help":
            default:
                $this->sendHelp($sender);
                break;
        }

        return true;
    }

    private function sendHelp(Player $player): void {
        $player->sendMessage("§e=== Команды приватов ===");
        $player->sendMessage("§6/privates info §f- Информация о привате");
        $player->sendMessage("§6/privates list §f- Список ваших приватов");
        $player->sendMessage("§6/privates add <игрок> §f- Добавить участника");
        $player->sendMessage("§6/privates remove <игрок> §f- Удалить участника");
        $player->sendMessage("§6/privates members §f- Список участников");
        $player->sendMessage("§6/privates delete §f- Удалить приват");
        $player->sendMessage("§e========================");
        $player->sendMessage("§aДля создания привата поставьте один из блоков:");
        $player->sendMessage("§7• Железный блок - 5x5x5");
        $player->sendMessage("§6• Золотой блок - 7x7x7");
        $player->sendMessage("§b• Алмазный блок - 11x11x11");
        $player->sendMessage("§2• Изумрудный блок - 21x21x21");
        $player->sendMessage("§5• Незеритовый блок - 31x31x31");
    }

    private function handleInfo(Player $player): void {
        $position = $player->asPosition();
        $world = $position->getLevel()->getFolderName();
        
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private === null) {
            $player->sendMessage($this->plugin->getMessage("not-in-private"));
            return;
        }

        $player->sendMessage("§e=== Информация о привате ===");
        $player->sendMessage("§6Владелец: §f" . $private->getOwner());
        $player->sendMessage("§6Размер: §f" . $private->getSize() . "x" . $private->getSize() . "x" . $private->getSize());
        $player->sendMessage("§6Тип блока: §f" . $private->getBlockTypeName());
        $player->sendMessage("§6Участников: §f" . count($private->getMembers()));
        $player->sendMessage("§6Центр: §f" . $private->getCenter()->getX() . ", " . $private->getCenter()->getY() . ", " . $private->getCenter()->getZ());
    }

    private function handleList(Player $player): void {
        $privates = $this->plugin->getPrivateManager()->getPrivateByOwner($player->getName());
        
        if (empty($privates)) {
            $player->sendMessage($this->plugin->getMessage("no-privates"));
            return;
        }

        $player->sendMessage("§e=== Ваши приваты ===");
        foreach ($privates as $private) {
            $player->sendMessage("§6• §f" . $private->getBlockTypeName() . " §7(" . 
                $private->getCenter()->getX() . ", " . $private->getCenter()->getY() . ", " . $private->getCenter()->getZ() . 
                ") §6Размер: §f" . $private->getSize() . "x" . $private->getSize() . "x" . $private->getSize());
        }
    }

    private function handleAddMember(Player $player, string $memberName): void {
        $position = $player->asPosition();
        $world = $position->getLevel()->getFolderName();
        
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private === null) {
            $player->sendMessage($this->plugin->getMessage("not-in-private"));
            return;
        }

        if ($private->getOwner() !== $player->getName()) {
            $player->sendMessage($this->plugin->getMessage("not-owner"));
            return;
        }

        if ($private->isMember($memberName)) {
            $player->sendMessage($this->plugin->getMessage("already-member", ["player" => $memberName]));
            return;
        }

        $private->addMember($memberName);
        $player->sendMessage($this->plugin->getMessage("member-added", ["player" => $memberName]));
        
        $target = $this->plugin->getServer()->getPlayer($memberName);
        if ($target !== null) {
            $target->sendMessage($this->plugin->getMessage("added-to-private", ["owner" => $player->getName()]));
        }
    }

    private function handleRemoveMember(Player $player, string $memberName): void {
        $position = $player->asPosition();
        $world = $position->getLevel()->getFolderName();
        
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private === null) {
            $player->sendMessage($this->plugin->getMessage("not-in-private"));
            return;
        }

        if ($private->getOwner() !== $player->getName()) {
            $player->sendMessage($this->plugin->getMessage("not-owner"));
            return;
        }

        if (!$private->isMember($memberName)) {
            $player->sendMessage($this->plugin->getMessage("not-member", ["player" => $memberName]));
            return;
        }

        $private->removeMember($memberName);
        $player->sendMessage($this->plugin->getMessage("member-removed", ["player" => $memberName]));
        
        $target = $this->plugin->getServer()->getPlayer($memberName);
        if ($target !== null) {
            $target->sendMessage($this->plugin->getMessage("removed-from-private", ["owner" => $player->getName()]));
        }
    }

    private function handleMembers(Player $player): void {
        $position = $player->asPosition();
        $world = $position->getLevel()->getFolderName();
        
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private === null) {
            $player->sendMessage($this->plugin->getMessage("not-in-private"));
            return;
        }

        $members = $private->getMembers();
        if (empty($members)) {
            $player->sendMessage("§eУ этого привата нет участников");
            return;
        }

        $player->sendMessage("§e=== Участники привата ===");
        $player->sendMessage("§6Владелец: §f" . $private->getOwner());
        $player->sendMessage("§6Участники:");
        foreach ($members as $member) {
            $player->sendMessage("§7• §f" . $member);
        }
    }

    private function handleDelete(Player $player): void {
        $position = $player->asPosition();
        $world = $position->getLevel()->getFolderName();
        
        $private = $this->plugin->getPrivateManager()->getPrivateAt($position, $world);
        if ($private === null) {
            $player->sendMessage($this->plugin->getMessage("not-in-private"));
            return;
        }

        if ($private->getOwner() !== $player->getName() && !$player->hasPermission("privates.admin")) {
            $player->sendMessage($this->plugin->getMessage("not-owner"));
            return;
        }

        $this->plugin->getPrivateManager()->removePrivate($private->getId());
        $player->sendMessage($this->plugin->getMessage("private-deleted"));
    }
} 