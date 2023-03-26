<?php

namespace Domain\Product\Actions;

use Domain\Product\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteProductAction
{
    use AsAction;

    public function __construct(
        protected Product $product
    ) {

    }
    /**
     * delete product
     */
    public function handle(int $productId): bool
    {
        return $this->product->destroy($productId);
    }
}
