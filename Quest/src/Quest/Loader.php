<?php

declare(strict_types=1);

namespace Quest\src\Kits;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {
    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onEnable() : void{
        self::$instance = $this;

    }
}