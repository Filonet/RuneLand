<?php

declare(strict_types=1);

namespace Kits\types;

use PlayerData\types\Group;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\ItemIds;

class Settings {

    public const array KITS = [
        Group::NONE => [
            "cooldown" => 3600,
            "items" =>
                [
                    [
                        'id' => ItemIds::CHAIN_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 1,
                            Enchantment::UNBREAKING => 1]
                    ], [
                    'id' => ItemIds::CHAIN_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1]
                ], [
                    'id' => ItemIds::CHAIN_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1]
                ], [
                    'id' => ItemIds::CHAIN_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1]
                ], [
                    'id' => ItemIds::STONE_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 1,
                        Enchantment::UNBREAKING => 1,
                        Enchantment::KNOCKBACK => 1]
                ], [
                    'id' => ItemIds::STONE_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1]
                ], [
                    'id' => ItemIds::STONE_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1]
                ], [
                    'id' => ItemIds::STONE_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1]
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1
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
        Group::HERO => [
            "cooldown" => 3600 * 24 * 2,
            "shulker" => [324, 100, 83],
            "items" =>
                [
                    [
                        'id' => ItemIds::IRON_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 2,
                            Enchantment::UNBREAKING => 1],
                        'name' => "§9§lHERO"
                    ], [
                    'id' => ItemIds::IRON_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::IRON_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::IRON_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::IRON_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 2,
                        Enchantment::UNBREAKING => 1,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::IRON_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::IRON_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::IRON_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHERO"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 1],
                    'name' => "§9§lHERO"
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
        Group::HUNTER => [
            "cooldown" => 3600 * 24 * 2,
            "shulker" => [330, 100, 82],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 1,
                            Enchantment::UNBREAKING => 1],
                        'name' => "§9§lHUNTER"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 1,
                        Enchantment::UNBREAKING => 1,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 1,
                        Enchantment::UNBREAKING => 1],
                    'name' => "§9§lHUNTER"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE
                ], [
                    'id' => ItemIds::RAW_BEEF,
                    'count' => 32
                ], [
                    'id' => ItemIds::CAKE
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 2
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 12
                ], [
                    'id' => ItemIds::COAL,
                    'count' => 24
                ], [
                    'id' => ItemIds::IRON_INGOT,
                    'count' => 12
                ], [
                    'id' => ItemIds::DYE,
                    'meta' => 4,
                    'count' => 24
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 32
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 32
                ], [
                    'id' => ItemIds::LOG2,
                    'meta' => 0,
                    'count' => 32
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 6,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 16
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 6,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 6
                ]
                ]
        ],
        Group::RANGER => [
            "cooldown" => 3600 * 24 * 3,
            "shulker" => [335, 100, 83],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 2,
                            Enchantment::UNBREAKING => 2,
                            Enchantment::RESPIRATION => 1],
                        'name' => "§9§lRANGER"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 2,
                        Enchantment::UNBREAKING => 2,
                        Enchantment::DEPTH_STRIDER => 1],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 2,
                        Enchantment::UNBREAKING => 2,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lRANGER"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                    'count' => 2
                ], [
                    'id' => ItemIds::COOKED_CHICKEN,
                    'count' => 63
                ], [
                    'id' => ItemIds::CAKE
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 2
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 16
                ], [
                    'id' => ItemIds::COAL_ORE,
                    'count' => 32
                ], [
                    'id' => ItemIds::IRON_ORE,
                    'count' => 20
                ], [
                    'id' => ItemIds::LAPIS_ORE,
                    'count' => 32
                ], [
                    'id' => ItemIds::GOLD_ORE,
                    'count' => 8
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 48
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 1,
                    'count' => 48
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 48
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 2,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 32
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 2,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 2
                ]
                ]
        ],
        Group::ELEMENTAL => [
            "cooldown" => 3600 * 24 * 4,
            "shulker" => [340, 100, 85],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 3,
                            Enchantment::UNBREAKING => 3,
                            Enchantment::RESPIRATION => 2],
                        'name' => "§9§lELEMENTAL"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 3,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::DEPTH_STRIDER => 3],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 3,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 2,
                        Enchantment::FIRE_ASPECT => 1],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 1,
                        Enchantment::EFFICIENCY => 3,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 3,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::INFINITY => 1],
                    'name' => "§9§lELEMENTAL"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                    'count' => 2
                ], [
                    'id' => ItemIds::TOTEM
                ], [
                    'id' => ItemIds::COOKED_CHICKEN,
                    'count' => 64
                ], [
                    'id' => ItemIds::CAKE
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 4
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 24
                ], [
                    'id' => ItemIds::COAL_ORE,
                    'count' => 48
                ], [
                    'id' => ItemIds::IRON_ORE,
                    'count' => 32
                ], [
                    'id' => ItemIds::LAPIS_ORE,
                    'count' => 48
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 1,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 64
                ], [
                    'id' => ItemIds::PLANKS,
                    'meta' => 3,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 32
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 3,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 3
                ]
                ]
        ],
        Group::PHANTOM => [
            "cooldown" => 3600 * 24 * 5,
            "shulker" => [339, 100, 96],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 4,
                            Enchantment::UNBREAKING => 3,
                            Enchantment::RESPIRATION => 3,
                            Enchantment::AQUA_AFFINITY => 1],
                        'name' => "§9§lPHANTOM"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 3,
                        Enchantment::FEATHER_FALLING => 2,
                        Enchantment::DEPTH_STRIDER => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 4,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 2,
                        Enchantment::FIRE_ASPECT => 2],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 2,
                        Enchantment::EFFICIENCY => 4,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 4,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::FLAME => 1,
                        Enchantment::INFINITY => 1],
                    'name' => "§9§lPHANTOM"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                    'count' => 3
                ], [
                    'id' => ItemIds::TOTEM
                ], [
                    'id' => ItemIds::COOKED_BEEF,
                    'count' => 64
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 4
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 32
                ], [
                    'id' => ItemIds::GOLD_ORE,
                    'count' => 20
                ], [
                    'id' => ItemIds::DIAMOND_ORE,
                    'count' => 8
                ], [
                    'id' => ItemIds::COAL_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::IRON_ORE,
                    'count' => 48
                ], [
                    'id' => ItemIds::LAPIS_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 1,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 64
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 4,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 32
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 4,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 4
                ]
                ]
        ],
        Group::ARCANA => [
            "cooldown" => 3600 * 24 * 6,
            "shulker" => [332, 100, 98],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 4,
                            Enchantment::UNBREAKING => 3,
                            Enchantment::RESPIRATION => 3,
                            Enchantment::AQUA_AFFINITY => 1],
                        'name' => "§9§lARCANA"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::FEATHER_FALLING => 3,
                        Enchantment::DEPTH_STRIDER => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 5,
                        Enchantment::KNOCKBACK => 1,
                        Enchantment::FIRE_ASPECT => 2,
                        Enchantment::LOOTING => 1,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 3,
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 1],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 4],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 4],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 5,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::FLAME => 1,
                        Enchantment::INFINITY => 1],
                    'name' => "§9§lARCANA"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                    'count' => 4
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::COOKED_BEEF,
                    'count' => 64
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 16
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 40
                ], [
                    'id' => ItemIds::GOLD_ORE,
                    'count' => 20
                ], [
                    'id' => ItemIds::DIAMOND_ORE,
                    'count' => 12
                ], [
                    'id' => ItemIds::EMERALD_ORE,
                    'count' => 2
                ], [
                    'id' => ItemIds::COAL_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::IRON_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::LAPIS_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 1,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 64
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 1,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 32
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 1,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 1
                ]
                ]
        ],
        Group::TITAN => [
            "cooldown" => 3600 * 24 * 7,
            "shulker" => [326, 100, 99],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 4,
                            Enchantment::UNBREAKING => 3,
                            Enchantment::RESPIRATION => 4,
                            Enchantment::AQUA_AFFINITY => 1],
                        'name' => "§9§lTITAN"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::FEATHER_FALLING => 4,
                        Enchantment::DEPTH_STRIDER => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 5,
                        Enchantment::FIRE_ASPECT => 2,
                        Enchantment::LOOTING => 2,
                        Enchantment::UNBREAKING => 2],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 4,
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 1,
                        Enchantment::FIRE_ASPECT => 1],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 4],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 4],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 5,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::FLAME => 1,
                        Enchantment::INFINITY => 1],
                    'name' => "§9§lTITAN"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                    'count' => 7
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::COOKED_BEEF,
                    'count' => 64
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 24
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 48
                ], [
                    'id' => ItemIds::GOLD_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::DIAMOND_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::EMERALD_ORE,
                    'count' => 32
                ], [
                    'id' => ItemIds::COAL_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::IRON_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::LAPIS_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 1,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 64
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 5,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 32
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 5,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 5
                ]
                ]
        ],
        Group::ELDER => [
            "cooldown" => 3600 * 24 * 8,
            "shulker" => [366, 100, 88],
            "items" =>
                [
                    [
                        'id' => ItemIds::DIAMOND_HELMET,
                        'count' => 1,
                        'enchant' => [
                            Enchantment::PROTECTION => 4,
                            Enchantment::UNBREAKING => 3,
                            Enchantment::RESPIRATION => 4,
                            Enchantment::AQUA_AFFINITY => 1],
                        'name' => "§9§lELDER"
                    ], [
                    'id' => ItemIds::DIAMOND_CHESTPLATE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::DIAMOND_LEGGINGS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::DIAMOND_BOOTS,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::PROTECTION => 4,
                        Enchantment::FEATHER_FALLING => 3,
                        Enchantment::DEPTH_STRIDER => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::DIAMOND_SWORD,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 5,
                        Enchantment::FIRE_ASPECT => 2,
                        Enchantment::LOOTING => 3,
                        Enchantment::UNBREAKING => 3],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::DIAMOND_AXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::SHARPNESS => 4,
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::KNOCKBACK => 1,
                        Enchantment::FIRE_ASPECT => 1],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::DIAMOND_PICKAXE,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 7,
                        Enchantment::UNBREAKING => 6],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::DIAMOND_SHOVEL,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::EFFICIENCY => 5,
                        Enchantment::UNBREAKING => 4],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::BOW,
                    'count' => 1,
                    'enchant' => [
                        Enchantment::POWER => 6,
                        Enchantment::UNBREAKING => 3,
                        Enchantment::FLAME => 1,
                        Enchantment::INFINITY => 1],
                    'name' => "§9§lELDER"
                ], [
                    'id' => ItemIds::GOLDEN_APPLE,
                    'count' => 8
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::TOTEM,
                    'count' => 1
                ], [
                    'id' => ItemIds::COOKED_BEEF,
                    'count' => 64
                ], [
                    'id' => ItemIds::BOOK,
                    'count' => 32
                ], [
                    'id' => ItemIds::SEA_LANTERN,
                    'count' => 48
                ], [
                    'id' => ItemIds::GOLD_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::DIAMOND_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::EMERALD_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::COAL_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::IRON_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::LAPIS_ORE,
                    'count' => 64
                ], [
                    'id' => ItemIds::ARROW,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 0,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 1,
                    'count' => 64
                ], [
                    'id' => ItemIds::LOG,
                    'meta' => 2,
                    'count' => 64
                ], [
                    'id' => ItemIds::WOOL,
                    'meta' => 14,
                    'count' => 32
                ], [
                    'id' => ItemIds::GLASS,
                    'count' => 32
                ], [
                    'id' => ItemIds::CONCRETE,
                    'meta' => 14,
                    'count' => 32
                ], [
                    'id' => ItemIds::BED,
                    'meta' => 14
                ]
                ]
        ],
    ];
}