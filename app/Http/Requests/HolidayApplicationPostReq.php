<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Providers\AppValidateProvider;
use App\Http\Middleware\HolidaySaveMiddleware;
use App\Helpers\DateTimeHelper;

class HolidayApplicationPostReq extends FormRequest
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

    /*
     * バリデーションを行う前にデータを加工
     */
    public function all($keys = null)
    {
        $params = parent::all($keys);
        /*
         * 期間をYYYY-MM-DD(dd)からYYYY-MM-DDにパース
         */
        $params['holiday_date_from'] = DateTimeHelper::parseDate($params['holiday_date_from']);

        if (array_key_exists('holiday_date_to', $params)) {
            $params['holiday_date_to'] = DateTimeHelper::parseDate($params['holiday_date_to']);
        }
        return $params;
    }

    public function rules()
    {
        return [
            'holiday_class_common_id' => 'required|max:10',
            'holiday_date_from' => 'required|date',
            'holiday_days' => 'nullable',
            'holiday_hours' => 'nullable|max:4',
            'reason' => 'required|max:255',
            'remarks' => 'nullable|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'holiday_class_common_id' => '区分',
            'holiday_date_from' => '開始日',
            'holiday_date_to' => '終了日',
            'holiday_days' => '期間（日間）',
            'holiday_time_from' => '開始時刻',
            'holiday_time_to' => '終了時刻',
            'holiday_hours' => '時間（時間）',
            'reason' => '理由',
            'remarks' => '備考',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('holiday_date_to', 'required|date|after:holiday_date_from', function ($input) {
            return $input->holiday_class_common_id == 1 || $input->holiday_class_common_id == 3;
        });
        $validator->sometimes('holiday_time_from', 'required|date_format:H:i', function ($input) {
            return $input->holiday_class_common_id == 2;
        });
        $validator->sometimes('holiday_time_to', 'required|date_format:H:i|after:holiday_time_from', function ($input) {
            return $input->holiday_class_common_id == 2;
        });
    }

    public function messages()
    {
        return [
            'hooliday_time_from.date_format:H:i' => '時刻を入力してください（HH:mm）',
            'hooliday_time_to.date_format:H:i' => '時刻を入力してください（HH:mm）',
            'holiday_date_to.after' => '休暇開始日以降の日を選択してください。',
            'holiday_time_to.after' => '休暇開始時間以降の時間を選択してください。'
        ];
    }
}
