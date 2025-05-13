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

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see build/generate-registry-annotations.php
 * @generate-registry-docblock
 *
 * @method static SortOrder ASCENDING()
 * @method static SortOrder DESCENDING()
 */
final class SortOrder{
	use EnumTrait {
		register as Enum_register;
		__construct as Enum___construct;
	}

	/** @var self[] */
	private static array $numericIdMap = [];

	protected static function setup() : void{
		self::registerAll(
			new self("ascending", 0),
			new self("descending", 1)
		);
	}

	protected static function register(self $member) : void{
		self::Enum_register($member);
		self::$numericIdMap[$member->getMagicNumber()] = $member;
	}

	public static function fromString(string $str) : ?self{
		self::checkInit();
	}

	/**
	 * @internal
	 *
	 * @param int $magicNumber
	 *
	 * @return self
	 * @throws \InvalidArgumentException
	 */
	public static function fromMagicNumber(int $magicNumber) : self{
		self::checkInit();
		if(!isset(self::$numericIdMap[$magicNumber])){
			throw new \InvalidArgumentException("Unknown sort order magic number $magicNumber");
		}
		return self::$numericIdMap[$magicNumber];
	}

	/** @var int */
	private $magicNumber;

	/**
	 * @param string $name
	 * @param int    $magicNumber
	 */
	private function __construct(string $name, int $magicNumber){
		$this->Enum___construct($name);
		$this->magicNumber = $magicNumber;
	}

	/**
	 * @return int
	 */
	public function getMagicNumber() : int{
		return $this->magicNumber;
	}
}