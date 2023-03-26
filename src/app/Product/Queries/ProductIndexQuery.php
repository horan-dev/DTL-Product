<?php

namespace App\Product\Queries;

use Illuminate\Http\Request;
use Domain\Product\Models\Product;
use Spatie\QueryBuilder\QueryBuilder;

class ProductIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Product::query()
            ->with(
                [
                'createdBy',
                ]
            );
        parent::__construct($query, $request);

        $this->allowedFilters(
            'name',
            'admin_id'
        )
            ->allowedSorts(
                'id'
            );
    }
}
