/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min');
require('jquery-timepicker/jquery.timepicker');
require('./my-timepicker');
require('./form-util')
const Swal = require('sweetalert2')
var moment = require('moment');


/*
 *タイムピッカーの値を受け取り差の時間を返す
 */
const getBussinessHours = function (start, end) {
    if ((start != '') && (end != '') && (end > start)) {
        let startMoment = moment(start, "HH:mm");
        let endMoment = moment(end, "HH:mm");
        let bussinessHours = endMoment.diff(startMoment, 'h', true);
        return bussinessHours;
    } else {
        return 'エラー';
    }
}

//timepicker変更時に上記の差の時間を表示する
const showBusinessHours = () => {
    if ($('#holiday_time_to').val() != '' && $('#holiday_time_from').val() != '') {
        $('#holiday_hours').val(getBussinessHours($('#holiday_time_from').val(), $('#holiday_time_to').val()))
    }
}

//Ajax通信で休暇日数を取得し表示する関数
const showBusinessDays = () => {
    if ($('#holiday_date_from').val() != '' && ($('#holiday_date_to').val() != '')) {
        $.ajax({
            url: '/getDuration',
            type: 'GET',
            data: {
                'holiday_date_from': $('#holiday_date_from').val(),
                'holiday_date_to': $('#holiday_date_to').val()
            }
        }).done(data => $('#holiday_days').val(data));
    }
};

//休暇種別による活性コントロール関数
const controlDateTime = () => {
    const holidayType = $('#holiday_type_id').val();
        if (holidayType == 1 || holidayType == 3 || holidayType == 4) {
            $('.timepicker').prop('disabled', true);
            $('.datepicker').prop('disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);
            showBusinessDays();

        } else {
            $('#holiday_date_from').prop('disabled', false);
            $('#holiday_date_to').prop('disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
            showBusinessHours();
        }
};

$(function () {
    //datepicker初期化
    $('.datepicker').datetimepicker(initDatepicker.optWithHolidays);

    //画面初期化
    $(document).ready(function () {
        myTimePicker.initTime($('#holiday_time_from'), '09:00', '18:00', 15);
        myTimePicker.initTime($('#holiday_time_to'), '09:00', '18:00', 15);
        controlDateTime();
    });

    //種別のonClickイベント
    $('#holiday_type_id').on('change', function () {
        controlDateTime();
    });

    //日付のonClickイベント
    $('.datepicker').on('dp.change', function() { showBusinessDays() });

    //時間のonClickイベント
    $('.timepicker').on('change', function() { showBusinessHours() });
    //スペルチェックをさせない
    $("input[type='text'], textarea").attr('spellcheck', false);

    //申請押下時ダイアログ表示
    $('#submit_holiday').on('click', function() { dialogs.showDialog($('#holiday_application')) });
});
