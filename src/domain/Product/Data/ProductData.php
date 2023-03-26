<?php

namespace Domain\Product\Data;

use Shared\Bases\Data;

use Shared\Enums\Product\ProductTypeEnum;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ProductData extends Data
{
    public function __construct(
        public ?string $name,
        public ?int $admin_id,
        public ?string $status,
        public ?ProductTypeEnum $product_type,
    ) {
    }
}
