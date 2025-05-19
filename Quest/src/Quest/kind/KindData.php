<?php

declare(strict_types=1);

namespace Quest\kind;

class KindData {
    public function __construct(
        private \Closure $take,
        private \Closure $check,
        private ?\Closure $success,
        private bool $autoTakeNextQuest
    ) {}

    public function getTake() : \Closure {
        return $this->take;
    }

    public function getCheck() : \Closure {
        return $this->check;
    }

    public function getSuccess() : ?\Closure {
        return $this->success;
    }

    public function isAutoTakeNextQuest() : bool {
        return $this->autoTakeNextQuest;
    }
}
