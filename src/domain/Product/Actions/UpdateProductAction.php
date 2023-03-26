<?php

namespace Domain\Product\Actions;

use Domain\Product\Models\Product;
use Domain\Product\Data\ProductData;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateProductAction
{
    use AsAction;

    public function __construct(
        protected Product $product
    ) {

    }
    /**
     * update product
     */
    public function handle(int $productId, ProductData $data): bool
    {
        $product=$this->product->find($productId);

        //filter null values
        $updatedData= array_filter($data->toArray(), function ($v) { return !is_null($v); });
        return $product&&$updatedData ? $product->update($updatedData) : false;
    }
}
