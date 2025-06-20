<?php

declare(strict_types=1);

namespace NPC\manager;

use NPC\entity\CustomHuman;
use NPC\Loader;
use pocketmine\entity\Entity;
use pocketmine\entity\Skin;
use pocketmine\level\format\Chunk;
use pocketmine\level\Location;
use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

class Manager {

    private const TAG_SKIN = "Skin"; //TAG_Compound
    private const TAG_SKIN_NAME = "Name"; //TAG_String
    private const TAG_SKIN_DATA = "Data"; //TAG_ByteArray
    private const TAG_SKIN_CAPE_DATA = "CapeData"; //TAG_ByteArray
    private const TAG_SKIN_GEOMETRY_NAME = "GeometryName"; //TAG_String
    private const TAG_SKIN_GEOMETRY_DATA = "GeometryData"; //TAG_ByteArray

    public function __construct(
        private Loader $loader
    ){
        //NOOP
    }

    public function getHuman(Location $location, Skin $skin, ?\Closure $onUse = null) : ?CustomHuman{
        $x = (int) $location->x;
        $z = (int) $location->z;

        $level = $location->level;

        $chunk = $level->getChunk($x >> Chunk::COORD_BIT_SIZE, $z >> Chunk::COORD_BIT_SIZE);
        if ($chunk === null) {
            return null;
        }

        $chunk->setProtect(true);

        $nbt = Entity::createBaseNBT($location->asVector3(), null, $location->getYaw(), $location->getPitch());
        $nbt->setTag(
            new CompoundTag(self::TAG_SKIN, [
                new StringTag(self::TAG_SKIN_NAME, $skin->getSkinId()),
                new ByteArrayTag(self::TAG_SKIN_DATA, $skin->getSkinData()),
                new ByteArrayTag(self::TAG_SKIN_CAPE_DATA, $skin->getCapeData()),
                new StringTag(self::TAG_SKIN_GEOMETRY_NAME, $skin->getGeometryName()),
                new ByteArrayTag(self::TAG_SKIN_GEOMETRY_DATA, $skin->getGeometryData()),
            ]));

        return new CustomHuman($level, $nbt, $onUse);
    }

    public function getSkin(string $skinData, ?string $modelPath = null, string $skinId = "Custom_Human") : Skin {
        $skinData = file_get_contents($this->loader->getDataFolder() . "skins/" . $skinData . ".skindata");

        $geometryName = null;
        if ($modelPath !== null) {
            $geometryData = file_get_contents($this->loader->getDataFolder() . "geometry/" . $modelPath . ".json");
            $json = json_decode($geometryData, true);
            $geometryName = $json['minecraft:geometry'][0]['description']['identifier'];
        }

        return new Skin(
            $skinId,
            $skinData,
            "",
            $geometryName ?? "",
            $geometryData ?? ""
        );
    }
}