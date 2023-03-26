<?php

use Illuminate\Support\Facades\Schema;
use Domain\Product\States\Product\Active;
use Illuminate\Database\Schema\Blueprint;
use Shared\Enums\Product\ProductTypeEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status', 10)->default(Active::getMorphClass());
            $table->foreignId('admin_id')->constrained('users');
            $table->enum('product_type', ProductTypeEnum::getValues())
                 ->default(ProductTypeEnum::ITEM->value);

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('admin_id');
            $table->index('product_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
