<?php

declare(strict_types=1);

namespace FloatingText\types;

class Settings {
    
    /** @var array|null */
    private static ?array $floatingTexts = null;

    public function __construct(){
        //NOOP
    }

    /**
     * Генерирует плавающие тексты для привилегии
     * @param float $x Координата X
     * @param float $y Начальная координата Y
     * @param float $z Координата Z
     * @param string $privilege Название привилегии (например, "hero")
     * @param int $lines Количество строк описания
     * @param float $spacing Расстояние между строками
     * @return array Массив координат и текстов
     */
    private static function generatePrivilegeTexts(float $x, float $y, float $z, string $privilege, int $lines, float $spacing = 0.3): array {
        $texts = [];
        for ($i = 1; $i <= $lines; $i++) {
            $currentY = $y - (($i - 1) * $spacing);
            $texts[] = [$x, $currentY, $z, "%floating.text.{$privilege}{$i}%"];
        }
        return $texts;
    }

    /**
     * Генерирует плавающие тексты для полезных команд
     * @param float $x Координата X
     * @param float $y Начальная координата Y
     * @param float $z Координата Z
     * @param float $spacing Расстояние между строками
     * @return array Массив координат и текстов
     */
    private static function generateUsefulCommandsTexts(float $x, float $y, float $z, float $spacing = 0.3): array {
        $commands = [
            "title", "rtp", "wextend", "ps", "ah", "gps", "help", 
            "clan", "board", "itemtoggle", "shop", "buyer", 
            "exchange", "battlepass", "donate", "links"
        ];
        
        $texts = [];
        foreach ($commands as $index => $command) {
            $currentY = $y - ($index * $spacing);
            $texts[] = [$x, $currentY, $z, "%floating.text.useful.commands.{$command}%"];
        }
        return $texts;
    }

    /**
     * Генерирует плавающие тексты для списка цен на привилегии
     * @param float $x Координата X
     * @param float $y Начальная координата Y
     * @param float $z Координата Z
     * @param float $spacing Расстояние между строками
     * @return array Массив координат и текстов
     */
    private static function generatePriceListTexts(float $x, float $y, float $z, float $spacing = 0.3): array {
        $items = [
            "title", "group.mouth.hero", "group.mouth.hunter", "group.mouth.ranger",
            "group.mouth.elemental", "group.mouth.phantom", "group.mouth.arcana",
            "group.mouth.titan", "group.mouth.elder", "dc.donate", "dc.money", "buy.site"
        ];
        
        $texts = [];
        foreach ($items as $index => $item) {
            $currentY = $y - ($index * $spacing);
            $texts[] = [$x, $currentY, $z, "%floating.text.list.{$item}%"];
        }
        return $texts;
    }

    /**
     * Генерирует плавающие тексты по списку ключей
     * @param float $x Координата X
     * @param float $y Начальная координата Y
     * @param float $z Координата Z
     * @param array $keys Массив ключей переводов
     * @param float $spacing Расстояние между строками
     * @return array Массив координат и текстов
     */
    private static function generateTextsByKeys(float $x, float $y, float $z, array $keys, float $spacing = 0.3): array {
        $texts = [];
        foreach ($keys as $index => $key) {
            $currentY = $y - ($index * $spacing);
            $texts[] = [$x, $currentY, $z, "%{$key}%"];
        }
        return $texts;
    }

    /**
     * Возвращает массив плавающих текстов
     * @return array
     */
    public static function getFloatingTexts(): array {
        if (self::$floatingTexts === null) {
            self::$floatingTexts = [
                // Полезные команды (генерируются функцией)
                ...self::generateUsefulCommandsTexts(207.5, 126, 197.5),

                // Список цен на привилегии (генерируется функцией)
                ...self::generatePriceListTexts(193.5, 124.3, 197.5),

                // Привилегии (генерируются функцией)
                ...self::generatePrivilegeTexts(324.5, 103.5, 83.5, "hero", 9),
                ...self::generatePrivilegeTexts(330.5, 103.5, 82.5, "hunter", 10),
                ...self::generatePrivilegeTexts(335.5, 103.5, 83.5, "ranger", 10),
                ...self::generatePrivilegeTexts(340.5, 103.5, 86.5, "elemental", 10),
                ...self::generatePrivilegeTexts(341.5, 103.5, 91.5, "phantom", 10),
                ...self::generatePrivilegeTexts(339.5, 103.5, 96.5, "arcana", 10),
                ...self::generatePrivilegeTexts(332.5, 103.5, 98.5, "titan", 10),
                ...self::generatePrivilegeTexts(327.5, 103.5, 99.5, "elder", 11),
                ...self::generatePrivilegeTexts(347, 101, 77, "youtube", 4),
            ];
        }
        return self::$floatingTexts;
    }

    /**
     * Константа для обратной совместимости
     * @deprecated Используйте getFloatingTexts() вместо этого
     */
    public const array FLOATING_TEXTS = [];
}