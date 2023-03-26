<?php

namespace Shared\Traits;

trait EnumHelper
{
    /**
     * return array of enum values
     *
     * @return array
     */
    public static function getValues(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * Get random name from enums group
     *
     * @return string
     */
    public static function getRandomName(): string
    {
        $arr =  array();
        $arrDT = static::cases();

        for ($i = 0; $i < static::count(); $i++) {
            $arr[$i] = $arrDT[$i]->name;
        }
        $i = array_rand($arr, 1);
        return $arrDT[$i]->name;
    }

    /**
     * Get random name value enums group
     *
     * @return string
     */
    public static function getRandomValue(): string
    {
        $arr =  array();
        $arrDT = static::cases();

        for ($i = 0; $i < static::count(); $i++) {
            $arr[$i] = $arrDT[$i]->value;
        }
        $i = array_rand($arr, 1);

        return $arrDT[$i]->value;
    }

    /**
     * Get enum count
     *
     * @return integer
     */
    public static function count(): int
    {
        return count(static::cases());
    }

    /**
     * Get enum items as key value
     *
     * @return string
     */
    public static function getKeyValue(): array
    {
        $arr =  array();
        $arrDT = static::cases();

        for ($i = 0; $i < static::count(); $i++) {
            $arr[$arrDT[$i]->value] = $arrDT[$i]->value;
        }
        return $arr;
    }

    /**
     * Get enum items as key value
     *
     * @return string
     */
    public static function getHumanKeyValue(): array
    {
        $arr =  array();
        $arrDT = static::cases();

        for ($i = 0; $i < static::count(); $i++) {
            $arr[$arrDT[$i]->value] = \Str::title(\Str::replace('_', ' ', $arrDT[$i]->value));
        }
        return $arr;
    }

    public static function getKeyTranslatedValue(string $langPath): array
    {
        $arr =  array();
        $arrDT = static::cases();

        for ($i = 0; $i < static::count(); $i++) {
            $arr[$arrDT[$i]->value] = __($langPath . '.' . $arrDT[$i]->value);
        }
        return $arr;
    }
}
