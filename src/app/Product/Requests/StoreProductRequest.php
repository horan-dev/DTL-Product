<?php

namespace App\Product\Requests;

use Domain\Product\States\Product\Active;
use Shared\Enums\Product\ProductTypeEnum;
use Domain\Product\States\Product\Inactive;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'status' =>  ['in:' . implode(",", [Active::getMorphClass(),Inactive::getMorphClass()]), 'required'],
            'product_type' =>  [ProductTypeEnum::getValuesAsInRule(), 'required'],
        ];
    }
}
