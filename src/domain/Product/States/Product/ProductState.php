<?php

namespace Domain\Product\States\Product;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ProductState extends State
{
    private string $field = 'status';

    /**
     * @throws \Spatie\ModelStates\Exceptions\InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()->default(Active::class)
            ->allowTransition([Active::class], Inactive::class)
            ->allowTransition([Inactive::class], Active::class);
    }
}
