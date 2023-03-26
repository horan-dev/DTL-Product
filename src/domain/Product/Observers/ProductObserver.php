<?php

namespace Domain\Product\Observers;

use Mail;
use App\Mail\NewProductMail;
use Domain\Product\Models\Product;

class UserObserver
{
    //run after created product
    public function created(Product $product)
    {
        dd($product->createdBy());
        $createdBy=$product->createdBy->first();
        $mailData = [
            'title' => 'New Product Added',
            'product_name' => $product->name,
            'product_added_by' => $createdBy->name,
        ];

        Mail::to($createdBy->email)->send(new NewProductMail($mailData));
    }
}
