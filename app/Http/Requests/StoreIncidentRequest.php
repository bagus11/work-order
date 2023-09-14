<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
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
            'categories_id'=>'required',
            'description_incident'=>'required',
            'description_incident'=>'required',
            'location_id'=>'required',
            'problem_id'=>'required',
            'start_date_incident'=>'required',
            'title_incident'=>'required',
        ];
    }
}
