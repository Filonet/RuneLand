<?php

declare(strict_types=1);

namespace Quest\kind;

use pocketmine\utils\SingletonTrait;

class KindFactory {
    use SingletonTrait;

    /** @var Kind[]  */
    private array $kinds = [];

    public function __construct(){
        $this->register(new Woodcutter());
    }

    public function register(Kind $kind) : void {
        $this->kinds[$kind::class] = $kind;
    }

    public function get(string $class) : ?Kind {
        return $this->kinds[$class] ?? null;
    }
}