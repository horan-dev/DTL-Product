<?php

namespace Domain\Product\Actions;

use Domain\Product\Models\Product;
use Domain\Product\Data\ProductData;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreProductAction
{
    use AsAction;

    public function __construct(
        protected Product $product
    ) {

    }
    /**
     * store product
     */
    public function handle(ProductData $data): Product
    {
        return $this->product->create($data->toArray());
    }
}
