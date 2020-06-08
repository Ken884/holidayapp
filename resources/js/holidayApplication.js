/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min');
require('jquery-timepicker/jquery.timepicker');
require('./my-timepicker');
var moment = require('moment');


/*
 *土日を除いた休暇期間を返す関数
    const getBussinessDays = function(start, end){
    let bussinessDays = 0;
    let d = new Date(start);
    let e = new Date(end);
    while (d <= e){
        if(d.getDay() != 0 && d.getDay() != 6 ) bussinessDays++;
        d.setDate(d.getDate()+1);
    }
    return bussinessDays;
}
*/

const getBussinessHours = function(start, end){
    if((start != '') && (end != '') && (end > start)){
    let d = moment(start, "HH:mm");
    let e = moment(end, "HH:mm");
    let bussinessHours = e.diff(d, 'h', true);
    return bussinessHours;
    }else{
        return 'エラー';
    }
}

//JSONで受け取った祝日リストをミリ秒の配列に変換
const yasumis = () => $('#holiday_date').data('json').map(yasumi => new Date(`${yasumi} 00:00:00`));


$(function () {
    $('.datepicker').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD(dd)',
        disabledDates: yasumis,
        daysOfWeekDisabled: [0, 6],
        locale: 'ja'
    });
    $(document).ready(function(){
        myTimePicker.initTime($('#holiday_time_from'), '09:00', '18:00', 15);
        myTimePicker.initTime($('#holiday_time_to'), '09:00', '18:00', 15);
        const holidayClass = $('#holiday_class_common_id').val();
        if(holidayClass==1 || holidayClass==3){
            $('.timepicker').prop('disabled', true);
            $('.datepicker').prop('disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);

        }else{
            $('#holiday_date_from').prop('disabled', false);
            $('#holiday_date_to').prop('disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
            if($('#holiday_time_to').val() != '' && $('#holiday_time_from').val() != ''){
                $('#holiday_hours').val(getBussinessHours($('#holiday_time_from').val(), $('#holiday_time_to').val()))
            }
        }
    });
    $('#holiday_class_common_id').on('change', function(){
        const holidayClass = $('#holiday_class_common_id').val();
        if(holidayClass==1 || holidayClass==3){
            $('.timepicker').prop('disabled', true);
            $('.datepicker').prop('disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);

        }else{
            $('#holiday_date_from').prop('disabled', false);
            $('#holiday_date_to').prop('disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
        }
    });
    $('.datepicker').on('dp.change', function(){
        if($('#holiday_date_from').val() != '' && ($('#holiday_date_to').val() != '')) {
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
    $('.timepicker').on('change', function(){
        if($('#holiday_time_to').val() != '' && $('#holiday_time_from').val() != ''){
            $('#holiday_hours').val(getBussinessHours($('#holiday_time_from').val(), $('#holiday_time_to').val()))
        }
    });
    $("input[type='text'], textarea").attr('spellcheck',false);
    
});
