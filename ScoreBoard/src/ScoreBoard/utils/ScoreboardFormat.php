<?php

declare(strict_types=1);

namespace ScoreBoard\utils;

use pocketmine\Player;
use function array_fill;
use function spl_object_id;
use function str_repeat;

final class ScoreboardFormat{

	private const int MAX_LINES = 15;

	private function __construct(){
		//NOOP
	}

	/** @var Scoreboard[] */
	private static $scoreboards;

	/**
	 * @param Player $player
	 * @param string $title
	 * @param array $lines
	 * @param int $leftAlignCount
	 * @param int $bottomAlignCount
	 * @param int $rightAlignCount
	 * @param SortOrder|null $sortOrder
	 */
	public static function sendScoreboard(Player $player, string $title, array $lines, int $leftAlignCount = 1, int $bottomAlignCount = 0, int $rightAlignCount = 1, ?SortOrder $sortOrder = null) : void{
		if(count($lines) + $bottomAlignCount > self::MAX_LINES){
			throw new \InvalidArgumentException("Too much scoreboard lines! Max allowed: " . self::MAX_LINES);
		}
		$lines = array_merge($lines, array_fill(0, $bottomAlignCount, ""));
		$sortOrder = $sortOrder ?? SortOrder::DESCENDING();

		if(isset(self::$scoreboards[spl_object_id($player)])){
			$scoreboard = self::$scoreboards[spl_object_id($player)];
			if($scoreboard->getObjective()->displayName !== $title or $scoreboard->getObjective()->sortOrder === $sortOrder){
				$scoreboard->remove();
				$scoreboard = self::$scoreboards[spl_object_id($player)] = new Scoreboard($player, new Objective($title, DisplaySlot::SIDEBAR(), $sortOrder));;
			}
		}else{
			$scoreboard = self::$scoreboards[spl_object_id($player)] = new Scoreboard($player, new Objective($title, DisplaySlot::SIDEBAR(), $sortOrder));;
		}

		$flip = $sortOrder->equals(SortOrder::DESCENDING());
		$maxIndex = count($lines) - 1;

		$leftAlign = str_repeat(" ", $leftAlignCount);
		$rightAlign = str_repeat(" ", $rightAlignCount);

		$existingLines = [];
		foreach($lines as $index => $line){
			$line = $leftAlign . $line . $rightAlign;
			while(isset($existingLines[$line])){
				$line = $line . " ";
			}
			$existingLines[$line] = true;
			$scoreboard->setScore($line, $flip ? $maxIndex - $index : $index);
		}

		foreach($scoreboard->getEntries() as $entry){
			if(!isset($existingLines[$entry->customName])){
				$scoreboard->removeScore($entry->customName);
			}
		}
	}

	/**
	 * @param Player $player
	 *
	 * @return Scoreboard|null
	 */
	public static function getScoreboard(Player $player) : ?Scoreboard{
		return self::$scoreboards[spl_object_id($player)] ?? null;
	}

	/**
	 * @param Player $player
	 */
	public static function removeScoreboard(Player $player) : void{
		if(isset(self::$scoreboards[spl_object_id($player)])){
			self::$scoreboards[spl_object_id($player)]->remove();
			unset(self::$scoreboards[spl_object_id($player)]);
		}
	}
}