<?php

namespace Domain\Product\Actions;

use Domain\Product\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class ViewProductAction
{
    use AsAction;

    public function __construct(
        protected Product $product
    ) {

    }
    /**
     * view product
     */
    public function handle(int $productId): Product|null
    {
        return $this->product->with('createdBy')
            ->where('id', $productId)->first();
    }
}
