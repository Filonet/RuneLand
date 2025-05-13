<?php

declare(strict_types=1);

namespace Groups\utils;

use Groups\types\Settings;

class Utils {

    public function __construct(){
        //NOOP
    }

    public static function filterString(string $string, bool $filter_ads = false, bool $filter_ints = false): string{
        if ($filter_ints) {
            $string = preg_replace(Settings::INTS_FILTER, '00000', $string);
        }

        if ($filter_ads) {
            if (isset(Settings::MESSAGES_NOT_REPLACE[$string])) {
                return $string;
            }

            $list = Settings::ADS_FILTER;

            foreach ($list as $regex) {
                if (!preg_match($regex, $string)) {
                    continue;
                }

                return Settings::REPLACE_SWEAR;
            }
        }
        return $string;
    }

    public static function checkString(string $s): string{
        static $re_badwords = NULL;

        if ($re_badwords === NULL) {

            $swear_array = Settings::SWEAR_FILTER;

            $pretext = $swear_array['pre_text'];
            $badwords = $swear_array['bad_words'];
            $trans = $swear_array['trans'];

            $re_badwords = str_replace(
                '%RE_PRETEXT%',
                '(?:' . implode('|', $pretext) . ')',
                '~' . implode('|', $badwords) . '~sxuSX'
            );

            $re_badwords = strtr($re_badwords, $trans);
        }

        $ss = $s;
        $s = preg_replace(
            '~ [\p{Lu}3] (?>\p{Ll}+|/\\\\|[@36]+)++  #Вот
			(?= [\p{Lu}3] (?:\p{Ll} |/\\\\|[@36] ) ) #Бля
			~sxuSX', '$0 ', $s
        );

        $s = strtolower($s);

        preg_match_all(
            '~(?> \xd0[\xb0-\xbf]|\xd1[\x80-\x8f\x91]  #[а-я]
			|  /\\\\     #л
			|  @         #а
			|  [a-z\d]+
			)+
			~sxSX', $s, $m
        );

        $s = ' ' . implode(' ', $m[0]) . ' ';
        $trans = [
            '/\\' => 'л',
            '@' => 'а'
        ];

        $s = strtr($s, $trans);
        $trans = [
            '~ [3з]++ [3з\x20]*+ ~sxuSX' => 'з',
            '~ [6б]++ [6б\x20]*+ ~sxuSX' => 'б',
        ];

        $s = preg_replace(array_keys($trans), array_values($trans), $s);
        $s = preg_replace('/(  [\xd0\xd1][\x80-\xbf] \x20?  #optimized [а-я]
                             | [a-z\d] \x20?
                             ) \\1+
                           /sxSX', '$1', $s);

        $result = preg_match_all($re_badwords, $s, $m);

        if ($result > 0) {
            foreach ($m[0] as $w) {
                $re_w = '~' . preg_replace_callback('~(?:/\\\\|[^\x20])~suSX', self::make_regexp_callback(...), $w) . '~sxuiSX';
                $ss = preg_replace($re_w, Settings::REPLACE_SWEAR, $ss);
            }
        }

        return $ss;
    }

    private static function make_regexp_callback(array $m): array|string{
        $re_holes = '(?!/\\\\)[^\p{L}\d]';

        if ($m[0] === 'а') {
            $re = '[@аА]++ (?>[:holes:]|[@аА]+)*+';
        } elseif ($m[0] === 'з') {
            $re = '[3зЗ]++ (?>[:holes:]|[3зЗ]+)*+';
        } elseif ($m[0] === 'б') {
            $re = '[6бБ]++ (?>[:holes:]|[6бБ]+)*+';
        } elseif ($m[0] === 'л') {
            $re = '(?>[лЛ]+|/\\\\)++ (?>[:holes:]|[лЛ]+|/\\\\)*+';
        } else {
            $char = '[' . preg_quote($m[0] . mb_strtoupper($m[0]), '~') . ']';
            $re = str_replace('$0', $char, '$0++ (?>[:holes:]|$0+)*+');
        }

        return str_replace('[:holes:]', $re_holes, $re . "\r\n");
    }

    public static function hasAdvertisement(string $text): bool{
        $domainPattern = '/(\w+\.\w{2,})/';
        $ipPattern = '/\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b/';

        if (preg_match($domainPattern, $text) || preg_match($ipPattern, $text)) {
            return true;
        }

        $keywordsPattern = '/\b(?:ad|advertisement|promo|promotion|spam|free|click\s*here|win\s*money|реклама|спам|продвижение|бесплатно|клик\s*сюда|выиграть\s*деньги)\b/iu';

        return preg_match($keywordsPattern, $text) === 1;
    }
}