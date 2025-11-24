<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterAssetRequest extends FormRequest
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
        $rules = [
            'brand_id'    => 'required',
            'category_id' => 'required',
            'type_id'     => 'required',
            'pic_id'      => 'required',
            'location_id'      => 'required',
        ];

        if ($this->type == 2) {
            $rules['parent_id'] = 'required';
        }

        return $rules;
    }
}
