/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jquery-timepicker/jquery.timepicker')
var moment = require('moment')


/*
 *土日を除いた休暇期間を返す関数
    const getBussinessDays = function(start, end){
    let bussinessDays = 0;
    let d = new Date(start);
    let e = new Date(end);
    console.log(d);
    console.log(e);
    while (d <= e){
        if(d.getDay() != 0 && d.getDay() != 6 ) bussinessDays++;
        d.setDate(d.getDate()+1);
    }
    return bussinessDays;
}
*/

const getBussinessHours = function(start, end){
    let d = moment(start, "HH:mm");
    let e = moment(end, "HH:mm");
    let bussinessHours = e.diff(d, 'h', true);
    return bussinessHours;
}

//JSONで受け取った祝日リストをミリ秒の配列に変換
const yasumis = $('#holiday_date').data('json').map(yasumi => new Date(`${yasumi} 00:00:00`).getTime());


$(function () {
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd(D)',
        beforeShowDay: function (date) {
            
            console.log(date, date.getTime(), yasumis.includes(date.getTime()));
            if (date.getDay() == 0 || date.getDay() == 6 || yasumis.includes(date.getTime())) {
                // 土日祝日
                return [false, 'ui-state-disabled'];
            } else {
                // 平日
                return [true, ''];
            }
        }
    });
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        minTime: '09:00',
        maxTime: '18:00',
        dropdown: true,
        change: function(){$(this).get(0).dispatchEvent(new Event('change', {bubbles: true, composed: true}))}
    });
    $(document).ready(function(){
        const holidayClass = $('#holiday_class_common_id').val();
        if(holidayClass==1 || holidayClass==3){
            $('.timepicker').prop('disabled', true);
            $('.datepicker').datepicker('option', 'disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);

        }else{
            $('#holiday_date_from').datepicker('option', 'disabled', false);
            $('#holiday_date_to').datepicker('option','disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
        }
    });
    $('#holiday_class_common_id').on('change', function(){
        const holidayClass = $('#holiday_class_common_id').val();
        if(holidayClass==1 || holidayClass==3){
            $('.timepicker').prop('disabled', true);
            $('.datepicker').datepicker('option', 'disabled', false);
            $('.timepicker').val(null);
            $('#holiday_hours').val(null);

        }else{
            $('#holiday_date_from').datepicker('option', 'disabled', false);
            $('#holiday_date_to').datepicker('option','disabled', true);
            $('.timepicker').prop('disabled', false);
            $('#holiday_date_to').val(null);
            $('#holiday_days').val(null);
        }
    });
    $('.datepicker').on('change', function(){
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
