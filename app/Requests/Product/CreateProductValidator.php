<?php
namespace App\Requests\Product;

use App\Requests\BaseRequestFormApi;

class CreateProductValidator extends BaseRequestFormApi {

    /**
     * @return bool
     */
    public function authorized(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title'=>'required|min:3|max:50|unique:products,title',
            'description'=>'required|min:3|max:1000',
            'size'=>'required|numeric|min:30|max:100',
            'color'=>'required|in:red,green',
            'price'=>'nullable|numeric|min:1|max:10000',
        ];
    }
}
