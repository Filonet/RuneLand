<?php

declare(strict_types=1);

namespace NPC\manager;

use NPC\entity\CustomHuman;
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

    public function __construct(){
        //NOOP
    }

    public function spawnToAll(Location $location, Skin $skin, ?\Closure $onUse = null) : ?CustomHuman{
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

    public function getSkinDataFromPng(string $file) : string{
        $image = imagecreatefrompng($file);
        $data = "";
        for ($y = 0; $y < imagesy($image); ++$y) {
            for ($x = 0; $x < imagesx($image); ++$x) {
                $color = imagecolorsforindex($image, imagecolorat($image, $x, $y));
                $data .= chr($color["red"]) . chr($color["green"]) . chr($color["blue"]) . chr($color["alpha"] === 0 ? 0xff : ~$color["alpha"] << 1 & 0xff);
            }
        }

        imagedestroy($image);
        return $data;
    }
}