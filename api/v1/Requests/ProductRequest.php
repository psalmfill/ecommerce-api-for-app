<?php

namespace Api\v1\Repositories\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array',
            'images.*' => 'mimes:jpg,jpeg,png'
        ];
    }
}
