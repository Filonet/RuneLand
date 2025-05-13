<?php

declare(strict_types=1);

namespace Groups\types;

use PlayerData\data\PlayerDataFactory;
use pocketmine\Player;
use PlayerData\types\Group;

final class Permission {

    public function __construct(){
        //NOOP
    }

    public const INHERITANCE = 'inheritance';
    public const PERMISSIONS = 'permissions';

    public const GROUPS = [
        Group::NONE => [
            self::PERMISSIONS => [],
        ]
    ];

    private static array $permissionGroups = [];

    public static function getPermissionsFromGroupName(string $groupName) : array{
        if(!isset(self::$permissionGroups[$groupName])) {
            $permissions = [];

            if (!isset(Permission::GROUPS[$groupName])) {
                self::$permissionGroups[$groupName] = [];
                return [];
            }

            $groupInfo = Permission::GROUPS[$groupName];

            $groupPermissions = $groupInfo[Permission::PERMISSIONS] ?? [];
            foreach ($groupPermissions as $permissionName) {
                $permissions[$permissionName] = true;
            }

            $groupInheritance = $groupInfo[Permission::INHERITANCE] ?? [];
            foreach ($groupInheritance as $groupNameInheritance) {
                $groupNameInheritancePermissions = Permission::GROUPS[$groupNameInheritance][Permission::PERMISSIONS] ?? [];
                foreach ($groupNameInheritancePermissions as $permissionInheritanceName) {
                    $permissions[$permissionInheritanceName] = true;
                }
            }

            self::$permissionGroups[$groupName] = $permissions;
        }

        return self::$permissionGroups[$groupName];
    }

    public static function hasPermission(Player|string $groupName, string $permissionName) : bool {
        if ($groupName instanceof Player) {
            if (in_array($groupName->getLowerCaseName(), \PlayerData\types\Settings::UNLIMITED)) return true;

            $groupName = PlayerDataFactory::getData($groupName->getLowerCaseName())->getGroupName();
        }

        return isset(self::getPermissionsFromGroupName($groupName)[$permissionName]);
    }
}