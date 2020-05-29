<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Providers\AppValidateProvider;
use App\Http\Middleware\HolidaySaveMiddleware;

class HolidayDurationAjax extends FormRequest
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

    public function all($keys = null)
    {
        $params = parent::all($keys);
        return $params;

        $fromArr = preg_split('/\(/', $params['holiday_date_from']);
        $params['holiday_date_from'] = $fromArr[0];

        $toArr = preg_split('/\(/', $params['holiday_date_to']);
        $params['holiday_date_to'] = $toArr[0];

        return $params;
    }
}
