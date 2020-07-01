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
require('./table-util')
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
        $('.ha-datepicker').prop('disabled', false);
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
    //申請画面関連
    //datepicker初期化
    $('.ha-datepicker').datetimepicker(initDatepicker.optWithHolidays);


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
    $('.ha-datepicker').on('dp.change', function () { showBusinessDays() });

    //時間のonClickイベント
    $('.timepicker').on('change', function () { showBusinessHours() });
    //スペルチェックをさせない
    $("input[type='text'], textarea").attr('spellcheck', false);

    //申請押下時ダイアログ表示
    $('#submit_holiday').on('click', function () { dialogs.showDialog($('#holiday_application')) });

    //一覧画面関連
    $('.hh-datepicker').datetimepicker(initDatepicker.optWithHolidays);
    //DataTabale
    //ユーザー用一覧をDataTableとしてイニシャライズ
    const showHolidayUserTable = () => {
        tableUtil.initDataTable($('.ho-user'), ['提出日', '休暇種別', '申請状況', '詳細'], ['10%', '10%', '10%', '10%'],
            {
                3:
                    function (data) {
                        return '<a href=' + data + '><button type="button" class="btn btn-block btn-success">詳細</button></a>';
                    }
            })
    };

    //管理者用一覧をDataTableとしてイニシャライズ
    const showHolidayAdminTable = () => {
        tableUtil.initDataTable($('.ho-admin'), ['提出日', '氏名', '休暇種別' ,'申請状況', '詳細'], ['10%', '20%', '20%', '10%', '10%'],
            {
                4:
                    function (data) {
                        return '<a href=' + data + '><button type="button" class="btn btn-block btn-success">詳細</button></a>';
                    }
            })
    };

    $(document).ready(function () {
        showHolidayUserTable();
        showHolidayAdminTable();
    });

      //ユーザー用テーブルを検索によって再描画
  $('#showUserHoliday').on('click', function () {
    //AJAX通信・管理者用フォーム
    let userParams = $('#userSearchHoliday').serialize();
    $.ajax({
      url: '/searchUser',
      type: 'GET',
      data: userParams
    }).done(res => {
      $('.ho-user').DataTable().destroy();
      $('.ho-user').data('json', res['json']);
      showHolidayUserTable();
    });
  });
  
  //管理者用テーブルを検索によって再描画
  $('#showAdminHoliday').on('click', function () {
    //AJAX通信・管理者用フォーム
    let adminParams = $('#adminSearchHoliday').serialize();
    $.ajax({
      url: '/adminSearchHoliday',
      type: 'GET',
      data: adminParams
    }).done(res => {
      $('.ho-admin').DataTable().destroy();
      $('.ho-admin').data('json', res['json']);
      showHolidayAdminTable();
    });
  });

    //詳細画面関連
  //管理者用・承認ボタン
  $('.ho-authorize').on('click', function () {
    formUtil.alterAttr($('.ho-authorization'), 'authorization', 'authorized')
    dialogs.showDialogAndDo($('#holiday_show'), '承認しますか？', () => formUtil.customSubmit($('#holiday_show'), 'post', $('#holiday_show').data('href')));
  });
  //否認ボタン
  $('.ho-decline').on('click', function () {
    formUtil.alterAttr($('.ho-authorization'), 'authorization', 'declined')
    dialogs.showDialogAndDo($('#holiday_show'), '否認しますか？', () => formUtil.customSubmit($('#holiday_show'), 'post', $('#holiday_show').data('href')));
  });

  $(document).ready(function () {
      $('#holiday_days').val()
  });
});
