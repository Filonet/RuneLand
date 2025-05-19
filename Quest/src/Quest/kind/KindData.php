<?php

declare(strict_types=1);

namespace Quest\kind;

class KindData {
    public function __construct(
        private int $type,
        private string $text,
        private \Closure $check,
        private \Closure $success,
    ) {}

    public function getType() : int {
        return $this->type;
    }

    public function getText() : string {
        return $this->text;
    }

    public function getCheck() : \Closure {
        return $this->check;
    }

    public function getSuccess() : \Closure {
        return $this->success;
    }
}
