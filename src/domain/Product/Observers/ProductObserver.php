<?php

namespace Domain\Product\Observers;

use Mail;
use App\Mail\NewProductMail;
use Domain\Product\Models\Product;

class ProductObserver
{
    //run after created product
    public function created(Product $product)
    {
        $createdBy=$product->createdBy;
        $mailData = [
            'title' => 'New Product Added',
            'product_name' => $product->name,
            'product_added_by' => $createdBy->name,
        ];

        //send email
        Mail::to($createdBy->email)->send(new NewProductMail($mailData));
    }
}
