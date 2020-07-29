<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Providers\AppValidateProvider;
use App\Helpers\DateTimeHelper;

class ExpenseApplicationPostReq extends FormRequest
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
            'occurred_date.*' => 'required|date',
            'statement.*' => 'required|max:80',
            'amount.*' => 'required|integer|between:1,9999999',
            'remarks' => 'nullable|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'occurred_date.*' => '発生日',
            'statement.*' => '支払明細',
            'amount.*' => '金額',
            'remarks' => '備考',
        ];
    }
}
