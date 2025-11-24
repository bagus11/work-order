<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreDistributionRequest extends FormRequest
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
        $post = [];
        // if($request->request_type == 2){
        //     $post =[
        //         'location_id' => 'required',
        //         'destination_location_id' => 'required',
        //         'receiver_id' => 'required',
        //         'request_type' => 'required',                
        //         'notes' => 'required',
        //     ];
        // }else if($request->request_type == 3){
        //     $post =[
        //         'location_id' => 'required',
        //         'request_type' => 'required',                
        //         'notes' => 'required',
        //         'current_user'=> 'required',
        //     ];
        // }else if($request->request_type == 1){
        //     $post =[
        //         'location_id' => 'required',
        //         'request_type' => 'required', 
        //         'destination_location_id' => 'required',
        //         'receiver_id' => 'required',
        //         'request_type' => 'required',             
        //         'notes' => 'required',
        //         'current_user'=> 'required',
        //     ];
        // }

        return $post ;
    }
}
;