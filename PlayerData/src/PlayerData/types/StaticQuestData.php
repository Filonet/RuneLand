<?php

declare(strict_types=1);

namespace PlayerData\types;

class StaticQuestData {

    public function __construct(
        private int    $questId = -1,
        private float  $progress = 0.0
    ){}

    public static function make() : self{
        return new self();
    }

    public function getQuestId(): int {
        return $this->questId;
    }

    public function setQuestId(int $questId): void {
        $this->questId = $questId;
    }

    public function getProgress(): float {
        return $this->progress;
    }

    public function setProgress(float $progress): void {
        $this->progress = $progress;
    }
}