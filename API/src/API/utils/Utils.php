<?php

declare(strict_types=1);

namespace API\utils;

use PlayerData\Language;
use pocketmine\Player;

class Utils {

    public function __construct(){
        //NOOP
    }

    public static function getFormattedTime($seconds, Player $player) : string{
        $seconds = (int) $seconds;
        $days = floor($seconds / (24 * 3600));
        $hours = floor(($seconds % (24 * 3600)) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        $result = '';

        if ($days > 0) {
            $result .= $days . ' ' . Language::translate("%api.utils.timer.days%", $player) . ' ';
        }

        if ($hours > 0) {
            $result .= $hours . ' ' . Language::translate("%api.utils.timer.hours%", $player) . ' ';
        }

        if ($minutes > 0) {
            $result .= $minutes . ' ' . Language::translate("%api.utils.timer.minutes%", $player) . ' ';
        }

        if ($remainingSeconds > 0) {
            $result .= $remainingSeconds . ' ' . Language::translate("%api.utils.timer.seconds%", $player) . ' ';
        }

        return trim($result);
    }
}