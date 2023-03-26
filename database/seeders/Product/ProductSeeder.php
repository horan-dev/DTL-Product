<?php

namespace Database\Seeders\Product;

use Illuminate\Database\Seeder;
use Domain\Product\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Product::factory()->count(3);

    }

}
