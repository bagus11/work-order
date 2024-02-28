<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRFPDetailRequest extends FormRequest
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
            'detailCodeEdit'=>'required',
            'requestCodeEdit'=>'required',
            'titleEdit'=>'required',
            'descriptionEdit'=>'required',
            'startDateEdit'=>'required',
            'datelineEdit'=>'required',
        ];
    }
}
