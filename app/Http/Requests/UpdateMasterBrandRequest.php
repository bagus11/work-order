<?php

namespace App\Http\Requests;

use App\Models\Inventory\Master\MasterBrand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateMasterBrandRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $validation = MasterBrand::where('name', $request->name_edit)->first();
        if($request->name_edit == $validation->name){
            $post =[
                'name_edit' => 'required'
            ];
        }else{
            $post =[
                'name_edit' => 'required|unique:master_brand,name'
            ];
        }
        return $post;
    }
}
