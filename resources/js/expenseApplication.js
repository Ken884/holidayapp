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
    if($('.is-invalid').length == 0 && $('[name="expense_id"]').data('mode') == 'new') {
      $('.dynamic-table .addRow').click();
    }
  });

  //申請押下時ダイアログを表示
  $('#submit_expense').on('click', function() {
    dialogs.showDialog();
  });


  
//詳細画面関連
  //管理者用・承認ボタン
  $('.authorize').on('click', function() {
    formUtil.alterAttr($('.authorization'), 'authorization', 'authorized')
    dialogs.showDialogAndDo($('#expense_show'), '承認しますか？', () => formUtil.customSubmit($('#expense_show'), 'post', $('#expense_show').data('href')));
  });
  //否認ボタン
  $('.decline').on('click', function() {
    formUtil.alterAttr($('.authorization'), 'authorization', 'declined')
    dialogs.showDialogAndDo($('#expense_show'), '否認しますか？', () => formUtil.customSubmit($('#expense_show'), 'post', $('#expense_show').data('href')));
  });
});
