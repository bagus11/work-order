<?php

namespace App\Http\Requests\StockOpname;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalSORequest extends FormRequest
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
            'approval_so_ticket_code' => 'required|string|max:255',
            'approval_so_status' => 'required',
            'approval_so_start_date' => 'required',
            'approval_so_description' => 'required',
        ];
    }
}
