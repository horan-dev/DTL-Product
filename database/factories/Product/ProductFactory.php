<?php

namespace Database\Factories\Product;

use Shared\Bases\BaseFactory;
use Domain\Client\Models\User;
use Domain\Product\Models\Product;
use Domain\Product\States\Product\Active;
use Shared\Enums\Product\ProductTypeEnum;

/**
 *
 */
class ProductFactory extends BaseFactory
{
    protected $model = Product::class;

    public function fields(): array
    {
        return [
            'name' => fake()->name(),
            'status' => Active::class,
            'admin_id' => User::factory(),
            'product_type' => ProductTypeEnum::getRandomValue()

        ];
    }

}
