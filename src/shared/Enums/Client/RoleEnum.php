<?php

namespace Shared\Enums\Client;

use Shared\Traits\EnumHelper;

enum RoleEnum: string
{
    use EnumHelper;

    case ADMIN = 'admin';

    public static function getRolesPermissions(): array
    {
        return [
            self::ADMIN->value => [
                PermissionEnum::MODEL_MANAGE->value,
            ],
        ];
    }
}
