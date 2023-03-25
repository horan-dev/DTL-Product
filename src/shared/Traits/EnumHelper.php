<?php

namespace Shared\Traits;

trait EnumHelper
{
    public static function getValues(): array
    {
        return array_column(static::cases(), 'value');
    }
}
