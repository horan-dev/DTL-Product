<?php

namespace Shared\Enums\Product;

use Shared\Traits\EnumHelper;

enum ProductTypeEnum: string
{
    use EnumHelper;

    case ITEM = 'item';
    case SERVICE = 'service';


}
