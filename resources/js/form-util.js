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

//ダイアログ関連
const dialogs = {};

//ボタンのonClickイベントのコールバック。submit前にダイアログを表示する。
dialogs.showDialog = form => {
    Swal.fire({
        title: 'この内容で登録しますか？',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    })
};

//ボタンイベントのダイアログ表示後の挙動をカスタム
dialogs.showDialogAndDo = (form, message, callback) => {
    Swal.fire({
        title: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ'
    }).then((result) => {
        if (result.value) {
            callback();
        }
    })
}

//グローバル化
window.dialogs = dialogs;

//datetimepicker関連
const initDatepicker = {};

//全ての日付選択可能な設定
initDatepicker.opt = {
    useCurrent: false,
    format: 'YYYY-MM-DD',
    locale: 'ja',
};

//JSONで受け取った祝日リストをミリ秒の配列に変換
const yasumis = () => {
    const yasumisData = $('#yasumi').data('json') || [];
    return yasumisData.map(yasumi => new Date(`${yasumi} 00:00:00`));
}

//土日祝日を除いた設定
initDatepicker.optWithHolidays = {
    useCurrent: false,
    format: 'YYYY-MM-DD',
    locale: 'ja',
    disabledDates: yasumis(),
    daysOfWeekDisabled: [0, 6],
}

//グローバル化
window.initDatepicker = initDatepicker;

//その他汎用
const formUtil = {};

//送信前にmethodとaction属性を書き換える
formUtil.customSubmit = (form, method, action) => {
    //二重送信防止
    if (formUtil.isSubmitting) {
        return
    }

    //送信中フラグ
    formUtil.isSubmitting = true;

    //元の属性を取得
    const beforeMethod = form.attr('method') || '';
    const beforeAction = form.attr('action') || '';

    //書き換え
    form.attr('method', method);
    form.attr('action', action);

    form.submit();

    // 属性と追加のパラメタを元に戻す
    form.attr('action', beforeAction);
    form.attr('method', beforeMethod);

    //送信中フラグ解除
    formUtil.isSubmitting = false;
}

//jQueryオブジェクトのnameとvalueをクリアした後アペンドする
formUtil.alterAttr = (element, name, value) => {
    element.attr('name', null).val(null);
    element.attr('name', name).val(value);
}

//グローバル化
window.formUtil = formUtil;