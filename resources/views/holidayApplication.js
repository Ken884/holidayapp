/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

function test() {
        alert('aaa');
}
$('.datepicker').datepicker({
    beforeShowDay: function (date) {
        if (date.getDay() == 0 || date.getDay() == 6) {
            // 日曜日
            return [false, 'ui-state-disabled'];
        } else {
            // 平日
            return [true, ''];
        }
    }
});
$('.timepicker').timepicker({
    format: 'HH:mm',
    interval: 15,
    minTime: '09:00',
    maxTime: '18:00'
});
