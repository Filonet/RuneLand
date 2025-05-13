<?php

declare(strict_types=1);

namespace Groups\types;

use PlayerData\data\PlayerDataFactory;
use PlayerData\types\Group;
use pocketmine\Player;

class Settings {
    
    public function __construct(){
        //NOOP
    }

    public const REPLACE_SWEAR = '******';

    public const INTS_FILTER = '/(?<![0-9])[0-9]{5}(?![0-9])/';

    public const MESSAGES_NOT_REPLACE = [
        '!нет' => true,
        'нет' => true,
        '! нет' => true,
        'сом' => true,
        '!сом' => true,
        '! сом' => true
    ];

    public const ADS_FILTER = [
        '/[\s\pP]\s*[tт]\s*[kк](?![а-яa-z])|(?<![а-яa-z])[tт]\s*[kк](?![а-яa-z])/ui',
        '/[\s\pP]\s*[pр]\s*[eе](?![а-яa-z])|(?<![а-яa-z])[pр]\s*[eе](?![а-яa-z])/ui',
        '/[\s\pP]\s*[cс]\s*[cс](?![а-яa-z])|(?<![а-яa-z])[cс]\s*[cс](?![а-яa-z])/ui',
        '/[\s\pP]\s*[rгpр]\s*[uyу](?![а-яa-z])|(?<![а-яa-z])[rгpр]\s*[uyу](?![а-яa-z])/ui',
        '/[\pP]\s*[nпн]\s*[eе]\s*[tт](?![а-яa-z])/ui',
        '/[\s\pP]\s*[cсkк]\s*[oо0]\s*[mм](?![а-яa-z])|(?<![а-яa-z])[cсkк]\s*[oо0]\s*[mм](?![а-яa-z])/ui',
        '/[\pP]\s*[fф]\s*[uyуа]\s*[nhн](?![а-яa-z])/ui',
        '/[\pP]\s*[pрп]\s*[rгpр]\s*[oо0](?![а-яa-z])/ui',
        '/[\pP]\s*[sс]\s*[uyу]\s*(?![а-яa-z])/ui'
    ];

    public const SWEAR_FILTER = [
        'bad_words' => [
            '(?<=\PL) %RE_PRETEXT%?
                      [hхx]_?[уyu]_?[ийiеeёяюju]     #хуй, хуя, хую, хуем, хуёвый, охуительный
                      #исключения:
                      (?<! _hue(?=_)     #HUE     -- цветовая палитра
                         | _hue(?=so_)   #hueso   -- испанское слово
                         | _хуе(?=дин)   #Хуедин  -- город в Румынии
                         | _hyu(?=ndai_) #Hyundai -- марка корейского автомобиля
                      )',
            '(?<=\PL) %RE_PRETEXT%?
                      [пp]_?[иieеё]_?[зz3]_?[дd](?=_?[:vowel:])',
            '(?<=\PL) %RE_PRETEXT%?
                      [eеё]_?
							#исключения
							(?<!н[eе][её]_|т_е_)    #неё, т.е. большие
                      [бb6]_? (?= [уyиi]_                       #ебу, еби
                                | [ыиiоoaаеeёуy]_?[:consonant:] #ебут, ебать, ебись, ебёт, поеботина, выебываться, ёбарь
                                   #исключения
                                  (?<!_ebo[kt](?=_)|буд)        #ebook, eboot, ее будут
                                | [лl](?:[оoаaыиiя]|ya)         #ебло, ебла, ебливая, еблись, еблысь, ёбля
                                | [нn]_?[уy]                    #ёбнул, ёбнутый
                                | [кk]_?[аa]                    #взъёбка
                                | [сc]_?[тt]                    #ебсти
                               )',
            '(?<=\PL) %RE_PRETEXT%
                      (?<= \pL\pL|\pL_\pL_)
                      [eеё]_?[бb6]    #долбоёб, дураёб, изъёб, заёб, заебай, разъебай, мудоёбы
            ',
            '(?<=\PL) ёб (?=\PL)',
            '(?<=\PL) %RE_PRETEXT%?
                      [бb6]_?[лl]_?(?:я|ya)(?: _         #бля
                                             | _?[тдtd]  #блять, бляди
                                           )',
            '(?<=\PL) [пp]_?[иieе]_?[дdg]_?[eеaаoо]_?[rpр]',
            '(?<=\PL) [мm]_?[уy]_?[дdg]_?[аa]  #мудак, мудачок
                      #исключения:
                      (?<!_myda(?=s_))  #Chelonia mydas -- морская зеленая (суповая) черепаха
            ',
            '(?<=\PL) [zж]_?h?_?[оo]_?[pп]_?[aаyуыiеeoо]',
            '(?<=\PL) [мm]_?[аa]_?[нnh]_?[дdg]_?[aаyуыiеeoо]  #манд[ауыео]
                      #исключения:
                      (?<! манда(?=[лн]|рин)
                         | manda(?=[ln]|rin)
                         | манде(?=ль)
                      )',
            '(?<=\PL) [гg]_?[оo]_?[вvb]_?[нnh]_?[оoаaяеeyу]',
            '(?<=\PL) f_?u_?[cс]_?k',

            '[^р]_?[scс]_?[yуu]_?[kк]_?[aаiи]',
            '[^р]_?[scс]_?[yуu]_?[4ч]_?[кk]',
            ' %RE_PRETEXT%?[хxh]_?[еe]_?[рpr](_?[нnh]_?(я|ya)| )',
            '[зz3]_?[аa]_?[лl]_?[уy]_?[пp]_?[аa]'
        ],

        'trans' => [
            '_' => '\x20',
            '\pL' => '[^\x20\d]',
            '\PL' => '[\x20\d]',
            '[:vowel:]' => '[аеиоуыэюяёaeioyu]',
            '[:consonant:]' => '[^аеиоуыэюяёaeioyu\x20\d]'
        ],

        'pre_text' => [

            '[уyоoаa]_?      (?=[еёeхx])',
            '[вvbсc]_?       (?=[хпбмгжxpmgj])',
            '[вvbсc]_?[ъь]_? (?=[еёe])',
            'ё_?             (?=[бb6])',

            '[вvb]_?[ыi]_?',
            '[зz3]_?[аa]_?',
            '[нnh]_?[аaеeиi]_?',
            '[вvb]_?[сc]_?               (?=[хпбмгжxpmgj])',
            '[оo]_?[тtбb6]_?             (?=[хпбмгжxpmgj])',
            '[оo]_?[тtбb6]_?[ъь]_?       (?=[еёe])',
            '[иiвvb]_?[зz3]_?            (?=[хпбмгжxpmgj])',
            '[иiвvb]_?[зz3]_?[ъь]_?      (?=[еёe])',
            '[иi]_?[сc]_?                (?=[хпбмгжxpmgj])',
            '[пpдdg]_?[оo]_? (?> [бb6]_? (?=[хпбмгжxpmgj]) | [бb6]_?  [ъь]_? (?=[еёe]) | [зz3]_? [аa] _? )?',

            '[пp]_?[рr]_?[оoиi]_?',
            '[зz3]_?[лl]_?[оo]_?',
            '[нnh]_?[аa]_?[дdg]_?         (?=[хпбмгжxpmgj])',
            '[нnh]_?[аa]_?[дdg]_?[ъь]_?   (?=[еёe])',
            '[пp]_?[оoаa]_?[дdg]_?        (?=[хпбмгжxpmgj])',
            '[пp]_?[оoаa]_?[дdg]_?[ъь]_?  (?=[еёe])',
            '[рr]_?[аa]_?[зz3сc]_?        (?=[хпбмгжxpmgj])',
            '[рr]_?[аa]_?[зz3сc]_?[ъь]_?  (?=[еёe])',
            '[вvb]_?[оo]_?[зz3сc]_?       (?=[хпбмгжxpmgj])',
            '[вvb]_?[оo]_?[зz3сc]_?[ъь]_? (?=[еёe])',

            '[нnh]_?[еe]_?[дdg]_?[оo]_?',
            '[пp]_?[еe]_?[рr]_?[еe]_?',
            '[oо]_?[дdg]_?[нnh]_?[оo]_?',
            '[кk]_?[oо]_?[нnh]_?[оo]_?',
            '[мm]_?[уy]_?[дdg]_?[oоaа]_?',
            '[oо]_?[сc]_?[тt]_?[оo]_?',
            '[дdg]_?[уy]_?[рpr]_?[оoаa]_?',
            '[хx]_?[уy]_?[дdg]_?[оoаa]_?',

            '[мm]_?[нnh]_?[оo]_?[гg]_?[оo]_?',
            '[мm]_?[оo]_?[рpr]_?[дdg]_?[оoаa]_?',
            '[мm]_?[оo]_?[зz3]_?[гg]_?[оoаa]_?',
            '[дdg]_?[оo]_?[лl]_?[бb6]_?[оoаa]_?',
            '[оo]_?[сc]_?[тt]_?[рpr]_?[оo]_?'
        ]
    ];

    public const CHAT = [
        Group::NONE => '{nickname}§r§8: §7{message}§r',
        Group::GRIEFER => '{nickname}§r§4: §7{message}§r',
        Group::HUSTANG => '{nickname}§r§6: §7{message}§r',
        Group::GHAST => '{nickname}§r§b: §7{message}§r',
        Group::WITHER => '{nickname}§r§e: §7{message}§r',
        Group::KRAKEN => '{nickname}§r§d: §7{message}§r',
        Group::DRAGON => '{nickname}§r§4: §7{message}§r',
        Group::STINGER => '{nickname}§r§5: §7{message}§r'
    ];

    public const TAG_LIST = [
        Group::NONE => [
            'message' => '§f§r{name}',
            'nametag' => '§f§r{name}'
        ],

        Group::GRIEFER => [
            'message' => '§c§o§lGRIEFER§r §f§r{name}',
            'nametag' => '§c§o§lGRIEFER§r §f§r{name}'
        ],

        Group::HUSTANG => [
            'message' => '§e§o§lHUSTANGE§r §f§r{name}',
            'nametag' => '§e§o§lHUSTANGE§r §f§r{name}'
        ],

        Group::GHAST => [
            'message' => '§b§o§lGHAST§r §f§r{name}',
            'nametag' => '§b§o§lGHAST§r §f§r{name}'
        ],

        Group::WITHER => [
            'message' => '§6§o§lWITHER§r §f§r{name}',
            'nametag' => '§6§o§lWITHER§r §f§r{name}'
        ],

        Group::KRAKEN => [
            'message' => '§a§o§lKRAKEN§r §f§r{name}',
            'nametag' => '§a§o§lKRAKEN§r §f§r{name}'
        ],

        Group::DRAGON => [
            'message' => '§5§o§lDRAGON§r §f§r{name}',
            'nametag' => '§5§o§lDRAGON§r §f§r{name}'
        ],

        Group::STINGER => [
            'message' => '§c§o§lSTINGER§r §f§r{name}',
            'nametag' => '§c§o§lSTINGER§r §f§r{name}'
        ],

        Group::ETERNITY => [
            'message' => '§d§o§lETERNITY§r §f§r{name}',
            'nametag' => '§d§o§lETERNITY§r §f§r{name}'
        ],
    ];
}