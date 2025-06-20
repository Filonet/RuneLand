<?php

declare(strict_types=1);

namespace Quest\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Quest\kind\KindFactory;
use Quest\kind\Woodcutter;

class QuestCommand extends Command {

    public function __construct(){
        parent::__construct("quest");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if ($sender instanceof Player) {
            if (!isset($args[0])) {
                return false;
            }

            $quests = KindFactory::getInstance()->getAll();
            if (isset($quests[$args[0]])) {
                $quests[$args[0]]->find($sender);
            }

            return true;
        }

        return false;
    }
}