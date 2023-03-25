<?php

namespace Shared\Enums\Client;

use Shared\Traits\EnumHelper;

enum PermissionEnum: string
{
    use EnumHelper;

    case MODEL_MANAGE = 'model.*';
    case MODEL_STORE = 'model.store.*';
    case MODEL_UPDATE = 'model.update.*';
    case MODEL_DESTROY = 'model.destroy.*';
    case MODEL_VIEW = 'model.view.*';
}
