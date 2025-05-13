<?php

declare(strict_types=1);

namespace PlayerData;

use DateTime;
use DateTimeZone;
use Exception;
use InvalidArgumentException;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use RuntimeException;
use function array_merge;
use function count;
use function file_get_contents;
use function gettype;
use function implode;
use function is_array;
use function is_float;
use function is_int;
use function min;
use function number_format;
use function preg_match_all;
use function str_replace;
use function strrpos;
use function substr;
use function time;
use function yaml_parse;

/**
 * A basic (not so) language system.
 */
abstract class Language{

	protected const DEFAULT = "en_US";
	protected const PATTERN = '/%(\w+\.(\w+\.){0,15}\w+)%/';

	public const KEY_PARENT_LANG = "langConfig.parentLang";

	/** @var array[] */
	protected static $languages = [];

	/**
	 * @param string $languageCode
	 * @param string $yaml_content
	 * 
	 * @return bool
	 */
	public static function load(string $languageCode, string $yaml_content) : bool{
		try{
			self::$languages[$languageCode] = array_merge(self::$languages[$languageCode] ?? [], yaml_parse($yaml_content));
		}catch(\Throwable $e){
			return false;
		}finally{
			return true;
		}
	}

	/**
	 * @param string $path
	 *
	 * @return bool
	 */
	public static function loadFromPath(string $path){
		foreach(new \RegexIterator(new \DirectoryIterator($path), "/(\\.yml|\\.yaml)$/i") as $file){
			if($file->isDot()){
				continue;
			}
			$fileName = $file->getFileName();
			if(!self::load(substr($fileName, 0, strrpos($fileName, ".")), file_get_contents($file->getPathName()))){
				return false;
			}
		}
		return true;
	}

	/**
	 * @param string							$string
	 * @param CommandSender|Player|string|null	$lang = null
	 * @param array								$replacements
	 * @param int								$counter = 1
	 * 
	 * @return string 
	 */
	public static function translate(string $string, $lang = null, array $replacements = [], int $counter = 1) : string{
		$lang = self::parseLang($lang);

		$result = $string;
		preg_match_all(self::PATTERN, $string, $matches);

		foreach($matches[0] as $match){
			$code = substr($match, 1, -1);

			$msg = null;
			if(isset(self::$languages[$lang][$code])){
				$msg = self::$languages[$lang][$code];
			}elseif(isset(self::$languages[$lang][self::KEY_PARENT_LANG])){
				$parentLang = self::$languages[$lang][self::KEY_PARENT_LANG];
				if(isset(self::$languages[$parentLang][$code])){
					$msg = self::$languages[$parentLang][$code];
				}
			}
			if($msg === null and isset(self::$languages[self::DEFAULT][$code])){
				$msg = self::$languages[self::DEFAULT][$code];
			}

			if($msg !== null){
				if(is_array($msg)){
					switch(count($msg)){
						case 2:
						case 3:
							$msg = self::countable($counter, $msg, $lang);
							break;
						default:
							$msg = implode($msg);
							break;
					}
				}

                foreach($replacements as $key => $r){
                    $msg = str_replace("%{$key}%", strval($r), $msg);
                }
                $result = str_replace("%{$code}%", $msg, $result);
            }
        }

		return $result;
	}

	/**
	 * @param CommandSender|Player|string|null $lang
	 * @param int|null $timestamp
	 *
	 * @return string
	 */
	public static function getDateNotation($lang = null, ?int $timestamp = null) : string{
		$lang = self::parseLang($lang);

		try{
			$dateTime = new DateTime("now", new DateTimeZone(self::translate("%runeland.dateTime.timeZone%", $lang)));
			$dateTime->setTimestamp($timestamp ?? time());
			return $dateTime->format(self::translate("%runeland.date.format%", $lang));
		}catch(Exception $e){
			throw new RuntimeException("Date Time failed: " . $e->getMessage());
		}
	}

	/**
	 * @param CommandSender|Player|string|null $lang
	 * @param int|null $timestamp
	 *
	 * @return string
	 * @throws RuntimeException
	 */
	public static function formatDateTime($lang = null, ?int $timestamp = null) : string{
		$lang = self::parseLang($lang);

		try{
			$dateTime = new DateTime("now", new DateTimeZone(self::translate("%runeland.dateTime.timeZone%", $lang)));
			$dateTime->setTimestamp($timestamp ?? time());
			$format = $dateTime->format(self::translate("%runeland.dateTime.format%", $lang));

			$timeZoneName = self::translate("%runeland.dateTime.timeZone.name%", $lang);
			if($timeZoneName !== ""){
				$format .= " " . $timeZoneName;
			}
			return $format;
		}catch(Exception $e){
			throw new RuntimeException("Date Time failed: " . $e->getMessage());
		}
	}

	/**
	 * @param float|int $number
	 * @param CommandSender|Player|string|null $lang
	 * @param int $decimals
	 *
	 * @return string
	 */
	public static function formatNumber($number, $lang = null, int $decimals = 0) : string{
		if(!is_int($number) and !is_float($number)){
			throw new InvalidArgumentException("Languages::formatNumber() expects parameter 1 to be float or int, " . gettype($number) . " given");
		}

		$lang = self::parseLang($lang);
		$decPoint = self::translate("%runeland.numberFormat.decPoint%", $lang);
		$thousandsSep = self::translate("%runeland.numberFormat.thousandsSep%", $lang);
		return number_format((float) $number, $decimals, $decPoint, $thousandsSep);
	}

	/**
	 * @param CommandSender|Player|string|null $lang
	 *
	 * @return string
	 */
	private static function parseLang($lang) : string{
		if($lang instanceof Player){
			$lang = $lang->getLocale();
		}elseif($lang instanceof CommandSender){
			$lang = self::DEFAULT;
		}
		if($lang === null or !isset(self::$languages[$lang])){
			$lang = self::DEFAULT;
		}
		if(!is_string($lang)){
			throw new \InvalidArgumentException("Language must be Player or string, got " . gettype($lang));
		}
		return $lang;
	}

	private static function countable(int $count, array $titles, string $lang) : string{
		if(self::isSlavic($lang)){
			if(count($titles) === 3){
				static $cases = [2, 0, 1, 1, 1, 2];
				return $titles[($count % 100 > 4 and $count % 100 < 20) ? 2 : $cases[min($count % 10, 5)]];
			}else{
				return $titles[($count % 10 === 1 and $count % 100 !== 11) ? 0 : 1];
			}
		}else{
			return $titles[$count === 1 ? 0 : 1];
		}
	}

	private static function isSlavic(string $lang) : bool{
		//TODO
		return $lang === "ru_RU" or $lang === "uk_UA";
	}
}