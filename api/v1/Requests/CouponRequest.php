<?php

namespace Api\v1\Repositories\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            "code" => "required",
            "start_date" => 'required|date',
            "end_date" => 'required|date',
            "quantity" => 'required|integer',
        ];
    }
}
