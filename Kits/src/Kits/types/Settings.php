<?php

declare(strict_types=1);

namespace Kits\types;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\ItemIds;

class Settings {

    /*
     * [
     * "shulker" => "x;y;z" (null)
     * "items" => [
     * [id, meta ?? 0, count ?? 1, enchant ?? [], name ?? null]
     * ]
     * ]
     */
    public const array KITS2 = [
        0 => [
            "cooldown" => 3600,
            "items" =>
                [
                    [
                        'id' => ItemIds::CHAIN_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 1,
                            Enchantment::UNBREAKING => 1],
                        'name' => "§7Набор - Игрока"
                    ], [
                    'id' => ItemIds::CHAIN_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::CHAIN_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::CHAIN_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::STONE_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 1,
                        Enchantment::UNBREAKING => 1,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::STONE_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::STONE_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::STONE_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'name' => "§7Набор - Игрока"
                ], [
                    'id' => ItemIds::BREAD,
                    'count' => 32
                ], [
                    'id' => ItemIds::CAKE
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 4
                ], [
                    'id' => ItemIds::COAL,
                    'count' => 8
                ], [
                    'id' => ItemIds::IRON_INGOT,
                    'count' => 4
                ], [
                    'id' => ItemIds::DYE, //lapis
                    'meta' => 4,
                    'count' => 8
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 16
                ], [
                    'id' => ItemIds::LOG, //oak
                    'meta' => 0,
                    'count' => 32
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 8,
                    'count' => 8
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 8
                ], [
                    'id' => ItemIds::CONCRETE,
                    'count' => 8
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 8
                ]
                ]
        ],
        1 => [
            "cooldown" => 3600 * 24 * 2,
            "permission" => "kit.hero",
            "shulker" => [324, 100, 83],
            "items" =>
                [
                    [
                        'id' => ItemIds::IRON_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 2,
                            Enchantment::UNBREAKING => 1],
                        'name' => "§r§7Набор - §9§lHERO"
                    ], [
                    'id' => ItemIds::IRON_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::IRON_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::IRON_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::IRON_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 2,
                        Enchantment::UNBREAKING => 1,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::IRON_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::IRON_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::IRON_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 1],
                    'name' => "§r§7Набор - §9§lHERO"
                ], [
                    'id' => ItemIds::BREAD,
                    'count' => 64
                ], [
                    'id' => ItemIds::CAKE
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 2
                ],[
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 4
                ], [
                    'id' => ItemIds::COAL,
                    'count' => 16
                ], [
                    'id' => ItemIds::IRON_INGOT,
                    'count' => 8
                ], [
                    'id' => ItemIds::DYE, //lapis
                    'meta' => 4,
                    'count' => 16
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 16
                ], [
                    'id' => ItemIds::LOG, //oak
                    'meta' => 0,
                    'count' => 24
                ], [
                    'id' => ItemIds::LOG2, //acacia
                    'meta' => 0,
                    'count' => 24
                ], [
                    'id' => ItemIds::LOG, //birch
                    'meta' => 2,
                    'count' => 24
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 11,
                    'count' => 16
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 16
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 11,
                    'count' => 16
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 11
                ]
                ]
        ],
    ];

    private const array KITS = [
        0 => [
            [
                'id' => "chainmail_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "chainmail_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "chainmail_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "chainmail_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "stone_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 1,
                    Enchantment::UNBREAKING => 1,
                    Enchantment::KNOCKBACK => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "stone_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "stone_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "stone_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "bow",
                'count' => 1,
                'name' => "§7Набор - Игрока"
            ], [
                'id' => "bread",
                'count' => 32
            ], [
                'id' => "cake"
            ], [
                'id' => "sea_lantern",
                'count' => 4
            ], [
                'id' => "coal_ore",
                'count' => 8
            ], [
                'id' => "iron_ore",
                'count' => 4
            ], [
                'id' => "lapis_lazuli_ore",
                'count' => 8
            ], [
                'id' => "arrow",
                'count' => 16
            ], [
                'id' => "oak_log",
                'count' => 32
            ], [
                'id' => "wool",
                'damage' => 8,
                'count' => 8
            ], [
                'id' => "glass",
                'count' => 8
            ], [
                'id' => "concrete",
                'count' => 8
            ], [
                'id' => "bed",
                'damage' => 8
            ],
        ],
        1 => [
            [
                'id' => "iron_helmet",
                'count' => 1,
                'enchant' => [
                    'protection' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_chestplate",
                'count' => 1,
                'enchant' => [
                    'protection' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_leggings",
                'count' => 1,
                'enchant' => [
                    'protection' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_boots",
                'count' => 1,
                'enchant' => [
                    'protection' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_sword",
                'count' => 1,
                'enchant' => [
                    'sharpness' => 2,
                    'unbreaking' => 1,
                    'knockback' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_axe",
                'count' => 1,
                'enchant' => [
                    'efficiency' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_pickaxe",
                'count' => 1,
                'enchant' => [
                    'efficiency' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "iron_shovel",
                'count' => 1,
                'enchant' => [
                    'efficiency' => 2,
                    'unbreaking' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    'power' => 1],
                'name' => "§r§7Набор - §9§lHERO"
            ], [
                'id' => "bread",
                'count' => 64
            ], [
                'id' => "cake"
            ], [
                'id' => "book",
                'count' => 2
            ],[
                'id' => "sea_lantern",
                'count' => 4
            ], [
                'id' => "coal_ore",
                'count' => 16
            ], [
                'id' => "iron_ore",
                'count' => 8
            ], [
                'id' => "lapis_lazuli_ore",
                'count' => 16
            ], [
                'id' => "golden_apple",
            ], [
                'id' => "arrow",
                'count' => 16
            ], [
                'id' => "oak_log",
                'count' => 24
            ], [
                'id' => "acacia_log",
                'damage' => 1,
                'count' => 24
            ], [
                'id' => "birch_log",
                'damage' => 2,
                'count' => 24
            ], [
                'id' => "wool",
                'damage' => 11,
                'count' => 16
            ], [
                'id' => "glass",
                'count' => 16
            ], [
                'id' => "concrete",
                'damage' => 11,
                'count' => 16
            ], [
                'id' => "bed",
                'damage' => 11
            ]
        ],
        2 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 1,
                    Enchantment::UNBREAKING => 1,
                    Enchantment::KNOCKBACK => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 1,
                    Enchantment::UNBREAKING => 1],
                'name' => "§r§7Набор - §9§lHUNTER"
            ], [
                'id' => "golden_apple"
            ], [
                'id' => "raw_beef",
                'count' => 32
            ], [
                'id' => "cake"
            ], [
                'id' => "book",
                'count' => 2
            ], [
                'id' => "sea_lantern",
                'count' => 12
            ], [
                'id' => "coal_ore",
                'count' => 24
            ], [
                'id' => "iron_ore",
                'count' => 12
            ], [
                'id' => "lapis_ore",
                'count' => 24
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "birch_log",
                'count' => 32
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 32
            ], [
                'id' => "acacia_log",
                'damage' => 2,
                'count' => 32
            ], [
                'id' => "wool",
                'damage' => 6,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 16
            ], [
                'id' => "concrete",
                'damage' => 6,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 6
            ]
        ],

        3 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 2,
                    Enchantment::UNBREAKING => 2,
                    Enchantment::RESPIRATION => 1],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 2,
                    Enchantment::UNBREAKING => 2,
                    Enchantment::DEPTH_STRIDER => 1],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 2,
                    Enchantment::UNBREAKING => 2,
                    Enchantment::KNOCKBACK => 1],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lRANGER"
            ], [
                'id' => "golden_apple",
                'count' => 2
            ], [
                'id' => ItemTypeIds::COOKED_CHICKEN,
                'count' => 63
            ], [
                'id' => "cake",
            ], [
                'id' => "book",
                'count' => 2
            ], [
                'id' => "sea_lantern",
                'count' => 16
            ], [
                'id' => "coal_ore",
                'count' => 32
            ], [
                'id' => "iron_ore",
                'count' => 20
            ], [
                'id' => "lapis_ore",
                'count' => 32
            ], [
                'id' => "gold_ore",
                'count' => 8
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 48
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 48
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 48
            ], [
                'id' => "wool",
                'damage' => 2,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 2,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 2
            ]

        ],
        4 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 3,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 2],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 3,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::DEPTH_STRIDER => 3],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 3,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 2,
                    Enchantment::FIRE_ASPECT => 1],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 1,
                    Enchantment::EFFICIENCY => 3,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 3,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lELEMENTAL"
            ], [
                'id' => "golden_apple",
                'count' => 2
            ], [
                'id' => "totem",
            ], [
                'id' => "cooked_chicken",
                'count' => 64
            ], [
                'id' => "cake",
            ], [
                'id' => "book",
                'count' => 4
            ], [
                'id' => "sea_lantern",
                'count' => 24
            ], [
                'id' => "coal_ore",
                'count' => 48
            ], [
                'id' => "iron_ore",
                'count' => 32
            ], [
                'id' => "lapis_ore",
                'count' => 48
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wooden_planks",
                'damage' => 3,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 3,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 3
            ]

        ],
        5 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 3,
                    Enchantment::AQUA_AFFINITY => 1],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 3,
                    Enchantment::FEATHER_FALLING => 2,
                    Enchantment::DEPTH_STRIDER => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 2,
                    Enchantment::FIRE_ASPECT => 2],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 2,
                    Enchantment::EFFICIENCY => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::FLAME => 1,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lPHANTOM"
            ], [
                'id' => "golden_apple",
                'count' => 3
            ], [
                'id' => "totem",
            ], [
                'id' => "cooked_beef",
                'count' => 64
            ], [
                'id' => "book",
                'count' => 4
            ], [
                'id' => "sea_lantern",
                'count' => 32
            ], [
                'id' => "gold_ore",
                'count' => 20
            ], [
                'id' => "diamond_ore",
                'count' => 8
            ], [
                'id' => "coal_ore",
                'count' => 64
            ], [
                'id' => "iron_ore",
                'count' => 48
            ], [
                'id' => "lapis_ore",
                'count' => 64
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wool",
                'damage' => 4,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 4,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 4
            ]
        ],
        6 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 3,
                    Enchantment::AQUA_AFFINITY => 1],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::FEATHER_FALLING => 3,
                    Enchantment::DEPTH_STRIDER => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 5,
                    Enchantment::KNOCKBACK => 1,
                    Enchantment::FIRE_ASPECT => 2,
                    Enchantment::LOOTING => 1,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 3,
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::FLAME => 1,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lARCANA"
            ], [
                'id' => "golden_apple",
                'count' => 4
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "cooked_beef",
                'count' => 64
            ], [
                'id' => "book",
                'count' => 16
            ], [
                'id' => "sea_lantern",
                'count' => 40
            ], [
                'id' => "gold_ore",
                'count' => 20
            ], [
                'id' => "diamond_ore",
                'count' => 12
            ], [
                'id' => "emerald_ore",
                'count' => 2
            ], [
                'id' => "coal_ore",
                'count' => 64
            ], [
                'id' => "iron_ore",
                'count' => 64
            ], [
                'id' => "lapis_ore",
                'count' => 64
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wool",
                'damage' => 1,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 1,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 1
            ]
        ],
        7 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 4,
                    Enchantment::AQUA_AFFINITY => 1],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::FEATHER_FALLING => 4,
                    Enchantment::DEPTH_STRIDER => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 5,
                    Enchantment::FIRE_ASPECT => 2,
                    Enchantment::LOOTING => 2,
                    Enchantment::UNBREAKING => 2],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 4,
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1,
                    Enchantment::FIRE_ASPECT => 1],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::FLAME => 1,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lTITAN"
            ], [
                'id' => "golden_apple",
                'count' => 7
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "cooked_beef",
                'count' => 64
            ], [
                'id' => "book",
                'count' => 24
            ], [
                'id' => "sea_lantern",
                'count' => 48
            ], [
                'id' => "gold_ore",
                'count' => 64
            ], [
                'id' => "diamond_ore",
                'count' => 64
            ], [
                'id' => "emerald_ore",
                'count' => 32
            ], [
                'id' => "coal_ore",
                'count' => 64
            ], [
                'id' => "iron_ore",
                'count' => 64
            ], [
                'id' => "lapis_ore",
                'count' => 64
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wool",
                'damage' => 5,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 5,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 5
            ]
        ],
        999 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 4,
                    Enchantment::AQUA_AFFINITY => 1],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::FEATHER_FALLING => 3,
                    Enchantment::DEPTH_STRIDER => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 5,
                    Enchantment::FIRE_ASPECT => 2,
                    Enchantment::LOOTING => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 4,
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1,
                    Enchantment::FIRE_ASPECT => 1],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 7,
                    Enchantment::UNBREAKING => 6],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 6,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::FLAME => 1,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lHELPER"
            ], [
                'id' => "golden_apple",
                'count' => 8
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "totem",
                'count' => 1
            ],
            [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "cooked_beef",
                'count' => 64
            ], [
                'id' => "book",
                'count' => 32
            ], [
                'id' => "sea_lantern",
                'count' => 48
            ], [
                'id' => "gold_ore",
                'count' => 64
            ], [
                'id' => "diamond_ore",
                'count' => 64
            ], [
                'id' => "emerald_ore",
                'count' => 64
            ], [
                'id' => "coal_ore",
                'count' => 64
            ], [
                'id' => "iron_ore",
                'count' => 64
            ], [
                'id' => "lapis_ore",
                'count' => 64
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wool",
                'damage' => 14,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 14,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 14
            ]
        ],
        8 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 4,
                    Enchantment::AQUA_AFFINITY => 1],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::FEATHER_FALLING => 3,
                    Enchantment::DEPTH_STRIDER => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 5,
                    Enchantment::FIRE_ASPECT => 2,
                    Enchantment::LOOTING => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 4,
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1,
                    Enchantment::FIRE_ASPECT => 1],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 7,
                    Enchantment::UNBREAKING => 6],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "bow",
                'count' => 1,
                'enchant' => [
                    Enchantment::POWER => 6,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::FLAME => 1,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lELDER"
            ], [
                'id' => "golden_apple",
                'count' => 8
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "totem",
                'count' => 1
            ],
            [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "cooked_beef",
                'count' => 64
            ], [
                'id' => "book",
                'count' => 32
            ], [
                'id' => "sea_lantern",
                'count' => 48
            ], [
                'id' => "gold_ore",
                'count' => 64
            ], [
                'id' => "diamond_ore",
                'count' => 64
            ], [
                'id' => "emerald_ore",
                'count' => 64
            ], [
                'id' => "coal_ore",
                'count' => 64
            ], [
                'id' => "iron_ore",
                'count' => 64
            ], [
                'id' => "lapis_ore",
                'count' => 64
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wool",
                'damage' => 14,
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'damage' => 14,
                'count' => 32
            ], [
                'id' => "bed",
                'damage' => 14
            ]
        ],999 => [
            [
                'id' => "diamond_helmet",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::RESPIRATION => 4,
                    Enchantment::AQUA_AFFINITY => 1],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_chestplate",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_leggings",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_boots",
                'count' => 1,
                'enchant' => [
                    Enchantment::PROTECTION => 4,
                    Enchantment::FEATHER_FALLING => 3,
                    Enchantment::DEPTH_STRIDER => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_sword",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 5,
                    Enchantment::FIRE_ASPECT => 2,
                    Enchantment::LOOTING => 3,
                    Enchantment::UNBREAKING => 3],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_axe",
                'count' => 1,
                'enchant' => [
                    Enchantment::SHARPNESS => 4,
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::KNOCKBACK => 1,
                    Enchantment::FIRE_ASPECT => 1],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_pickaxe",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 7,
                    Enchantment::UNBREAKING => 6],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "diamond_shovel",
                'count' => 1,
                'enchant' => [
                    Enchantment::EFFICIENCY => 5,
                    Enchantment::UNBREAKING => 4],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "bow",
                'count' => 1,

                'enchant' => [
                    Enchantment::POWER => 6,
                    Enchantment::UNBREAKING => 3,
                    Enchantment::FLAME => 1,
                    Enchantment::INFINITY => 1],
                'name' => "§r§7Набор - §9§lYOUTUBE"
            ], [
                'id' => "golden_apple",
                'count' => 8
            ], [
                'id' => "totem",
                'count' => 1
            ], [
                'id' => "totem",
                'count' => 1
            ],
            [
                'id' => "totem",
                'count' => 1
            ],
            [
                'id' => "cooked_mutton",
                'count' => 64
            ], [
                'id' => "book",
                'count' => 32
            ], [
                'id' => "sea_lantern",
                'count' => 48
            ], [
                'id' => "gold_ore",
                'count' => 64
            ], [
                'id' => "diamond_ore",
                'count' => 64
            ], [
                'id' => "emerald_ore",
                'count' => 64
            ], [
                'id' => "coal_ore",
                'count' => 64
            ], [
                'id' => "iron_ore",
                'count' => 64
            ], [
                'id' => "lapis_lazuli_ore",
                'count' => 64
            ], [
                'id' => "arrow",
                'count' => 64
            ], [
                'id' => "oak_log",
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 1,
                'count' => 64
            ], [
                'id' => "oak_log",
                'damage' => 2,
                'count' => 64
            ], [
                'id' => "wool",
                'count' => 32
            ], [
                'id' => "glass",
                'count' => 32
            ], [
                'id' => "concrete",
                'count' => 32
            ], [
                'id' => "bed",
            ]
        ]
    ];
    
}