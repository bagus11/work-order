<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualWORequest extends FormRequest
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
            'request_type'=>'required',
            'request_for'=>'required',
            'categories'=>'required',
            'problem_type'=>'required',
            'username'=>'required',
            'add_info'=>'required',
            'subject'=>'required',
        ];
    }
}
