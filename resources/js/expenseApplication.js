/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min');
require('./form-util');
require('./table-util');
var moment = require('moment');
const { data } = require('jquery');




$(function () {
  //申請画面関連  
  //提出日にシステム日付を表示
  $("[name='submit_datetime']").val(moment(new Date).format('YYYY-MM-DD'));

  //動的テーブルイニシャライズ
  tableUtil.dynamics();

  //生成された明細行の発生日をdatetimepickerとしてイニシャライズ
  $(document).on('focus', '.e-datepicker', function () {
    $(this).datetimepicker(initDatepicker.opt);
  });

  //新規作成画面読み込み時に明細1行目をレンダリング
  $(document).ready(function () {
    if ($('.is-invalid').length == 0 && $('[name="expense_id"]').data('mode') == 'new') {
      $('.dynamic-table .addRow').click();
    }
  });

  //申請押下時ダイアログを表示
  $('#submit_expense').on('click', function () {
    dialogs.showDialog($('#expense_application'));
  });



  //詳細画面関連
  //管理者用・承認ボタン
  $('.ex-authorize').on('click', function () {
    formUtil.alterAttr($('.ex-authorization'), 'authorization', 'authorized')
    dialogs.showDialogAndDo($('#expense_show'), '承認しますか？', () => formUtil.customSubmit($('#expense_show'), 'post', $('#expense_show').data('href')));
  });
  //否認ボタン
  $('.ex-decline').on('click', function () {
    formUtil.alterAttr($('.ex-authorization'), 'authorization', 'declined')
    dialogs.showDialogAndDo($('#expense_show'), '否認しますか？', () => formUtil.customSubmit($('#expense_show'), 'post', $('#expense_show').data('href')));
  });



  //一覧画面関連
  //ユーザー用一覧をDataTableとしてイニシャライズ
  const showUserTable = () => {
    tableUtil.initDataTable($('.ex-user'), ['提出日', '申請状況', '詳細'], ['10%','10%','10%'],
      {
        2:
          function (data) {
            return '<a href=' + data + '><button type="button" class="btn btn-block btn-success">詳細</button></a>';
          }
      })
  };

  //管理者用一覧をDataTableとしてイニシャライズ
  const showAdminTable = () => {
    tableUtil.initDataTable($('.ex-admin'), ['提出日', '氏名', '申請状況', '詳細'], ['20%', '20%', '10%', '10%'],
      {
        3:
          function (data) {
            return '<a href=' + data + '><button type="button" class="btn btn-block btn-success">詳細</button></a>';
          }
      })
  };



  //画面読み込み時にテーブル初期化

  $(document).ready(function () {
    showUserTable();
    showAdminTable();
  })
  
  //ユーザー用テーブルを検索によって再描画
  $('#showUser').on('click', function () {
    //AJAX通信・管理者用フォーム
    let userParams = $('#userSearch').serialize();
    $.ajax({
      url: '/userSearchExpense',
      type: 'GET',
      data: userParams
    }).done(res => {
      $('.ex-user').DataTable().destroy();
      $('.ex-user').data('json', res['json']);
      showUserTable();
    });
  });
  
  //管理者用テーブルを検索によって再描画
  $('#showAdmin').on('click', function () {
    //AJAX通信・管理者用フォーム
    let adminParams = $('#adminSearch').serialize();
    $.ajax({
      url: '/adminSearchExpense',
      type: 'GET',
      data: adminParams
    }).done(res => {
      $('.ex-admin').DataTable().destroy();
      $('.ex-admin').data('json', res['json']);
      showAdminTable();
    });
  });

});


