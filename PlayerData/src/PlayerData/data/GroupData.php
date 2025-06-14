<?php

declare(strict_types=1);

namespace PlayerData\data;

use PlayerData\types\Group;
use PlayerData\types\SessionIds;
use PlayerData\types\Title;

class GroupData {

    public function __construct(
        private string $group = Group::NONE,
        private int    $expirationGroup = 0,
        private string $title = Title::NONE,
    )
    {
    }

    public static function make() : self{
        return new self();
    }

    public function getGroup() : string {
        return $this->group;
    }

    public function setGroup(string $group) : void{
        $this->group = $group;
    }

    public function getTitle() : string{
        return $this->title;
    }

    public function setTitle(string $title) : void{
        $this->title = $title;
    }

    public function getExpirationGroup() : int {
        return $this->expirationGroup;
    }

    public function setExpirationGroup(int $expirationGroup) : void {
        $this->expirationGroup = $expirationGroup;
    }
}