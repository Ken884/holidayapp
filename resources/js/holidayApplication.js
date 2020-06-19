/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min');
require('jquery-timepicker/jquery.timepicker');
require('./my-timepicker');
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
/*
 *JSONで受け取った祝日リストをミリ秒の配列に変換
 */
const yasumis = () => {
    const yasumisData = $('#holiday_date').data('json') || [];
    return yasumisData.map(yasumi => new Date(`${yasumi} 00:00:00`));
}


$(function () {
    $('.datepicker').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
        disabledDates: yasumis(),
        daysOfWeekDisabled: [0, 6],
        locale: 'ja'
    });
    $(document).ready(function () {
        myTimePicker.initTime($('#holiday_time_from'), '09:00', '18:00', 15);
        myTimePicker.initTime($('#holiday_time_to'), '09:00', '18:00', 15);
        const holidayClass = $('#holiday_class_common_id').val();
        if (holidayClass == 1 || holidayClass == 3) {
            $('.timepicker').prop('disabled', true);
            $('.datepicker').prop('disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);

        } else {
            $('#holiday_date_from').prop('disabled', false);
            $('#holiday_date_to').prop('disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
            if ($('#holiday_time_to').val() != '' && $('#holiday_time_from').val() != '') {
                $('#holiday_hours').val(getBussinessHours($('#holiday_time_from').val(), $('#holiday_time_to').val()))
            }
        }
    });
    $('#holiday_class_common_id').on('change', function () {
        const holidayClass = $('#holiday_class_common_id').val();
        if (holidayClass == 1 || holidayClass == 3) {
            $('.timepicker').prop('disabled', true);
            $('.datepicker').prop('disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);

        } else {
            $('#holiday_date_from').prop('disabled', false);
            $('#holiday_date_to').prop('disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
        }
    });
    $('.datepicker').on('dp.change', function () {
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
    });
    $('.timepicker').on('change', function () {
        if ($('#holiday_time_to').val() != '' && $('#holiday_time_from').val() != '') {
            $('#holiday_hours').val(getBussinessHours($('#holiday_time_from').val(), $('#holiday_time_to').val()))
        }
    });
    $("input[type='text'], textarea").attr('spellcheck', false);
    $('#submit_holiday').on('click', function () {
        Swal.fire({
            title: 'この内容で登録しますか？',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ'
        }).then((result) => {
            if(result.value){
                $('#holiday_application').submit();
            }
        })
    });
});
