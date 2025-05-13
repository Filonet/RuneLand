<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace ScoreBoard\utils;

use Random\RandomException;
use function md5;
use function random_bytes;

class Objective{
	public DisplaySlot $displaySlot;
	public string $objectiveName;
	public string $displayName;
	public string $criteriaName;
	public SortOrder $sortOrder;

    /**
     * @throws RandomException
     */
    public function __construct(string $displayName, DisplaySlot $displaySlot, SortOrder $sortOrder){
		$this->displaySlot = $displaySlot;
		$this->objectiveName = md5(random_bytes(8)); //this avoid plugin conflicts and remove useless argument
		$this->displayName = $displayName;
		$this->criteriaName = "dummy";
		$this->sortOrder = $sortOrder;
	}
}