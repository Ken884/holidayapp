/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
const tableUtil = {};

//行追加・削除時の要素変化
const alterRowAttr = table => {

    //trタグの数に応じて行削除ボタンの表示を切り替える
    const rowCnt = table.find('tr').length;
    if (rowCnt == 4) {
      $('.removeRow').addClass('d-none');
    } else {
      $('.removeRow').removeClass('d-none');
    }
  
    //dynamic-numクラスの要素に行番号を動的に表示
    table.find(".dynamic-num").each(function (i) {
      $(this).val(i++);
    });
  
    //dynamic-dpクラスの要素の位置を調整（datepicker）
    table.find('.dynamic-dp').attr('style', 'position:relative');
  };

//動的テーブルの標準動作
tableUtil.dynamics = function () {

    // 動的テーブルに行の追加・削除ボタンを追加する
    $('.dynamic-table').each(function (i) {
        let colspan = 0; // 最後の行において横方向にセルを結合する用
        let rowCnt = 0;
        $(this).find('tr').each(function (j) {
            if (j == 0) {
                colspan = $(this).find('th').length + 1; // 見出し行から列数判定
            }
            if (j > 0) {
                rowCnt++;
                $(this).append('<td><button class="btn btn-danger removeRow float-right" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>');
                $('.removeRow').removeClass('d-none');
            }
        });
        $(this).find('tr').filter(':last').after('<tr><td colspan="' + colspan + '"><button class="btn btn-primary addRow float-right" type="button" tabindex="-1"><i class="fa fa-plus"></i></button></td></tr>');
        const maxRow = $(this).data('max-row');
        if (rowCnt - 1 >= maxRow) { // rowCntからテンプレート行を引く
            $(this).find('.addRow').attr('disabled', true);
        }
        alterRowAttr($(this));
    });

    // 動的テーブル追加ボタン押下時の処理
    $(document).on('click', '.dynamic-table .addRow', function () {
        const table = $(this).closest('table');
        const newRow = table.find('tr').filter('.template').clone(true).removeClass('template d-none');
        newRow.find('input,select, textarea').removeAttr('disabled');

        const lastRow = table.find('tr').filter(':last').prev();
        newRow.insertAfter(lastRow);

        alterRowAttr($(table));
    });

    // 動的テーブル削除ボタン押下時の処理
    $(document).on('click', '.dynamic-table .removeRow', function () {
        const table = $(this).closest('table');
        $(this).closest('tr').remove();

        const maxRow = parseInt(table.data('max-row'));
        const nowRowNum = parseInt(table.find('tr').length - 3); //見出し行、テンプレート行、+ ボタン行を引く
        if (nowRowNum < maxRow) {
            table.find('.addRow').attr('disabled', false)
        }

        alterRowAttr($(table));
    });
};

window.tableUtil = tableUtil;
