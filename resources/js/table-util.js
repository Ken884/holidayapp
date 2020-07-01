/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
const tableUtil = {};

//動的テーブル関連

//行追加・削除時の要素変化
const alterRowAttr = table => {

  //trタグの数に応じて行削除ボタンの表示を切り替える
  const rowCnt = table.find('tr').length;
  
  //新規画面ではtrタグは常に4（header, template, 1行目, 行追加ボタン）
  if (rowCnt == 4) {
    $('.removeRow').addClass('d-none');
  } else {
    $('.removeRow').removeClass('d-none');
  }

  //dynamic-numクラスの要素に行番号を動的に表示
  table.find(".dynamic-num").each(function (i) {
    console.log("init")
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

//一覧ページ用DataTable関連

//デフォルトの設定
const myOptions = {
  paging: true,
  lengthChange: false,
  searching: false,
  ordering: true,
  info: true,
  autoWidth: false,
  order: [],
  language: {
    processing: "処理中...",
    search: "検索",
    lengthMenu: "_MENU_件表示",
    info: "_TOTAL_ 件中 _START_ 件目から _END_ 件目まで表示",
    infoEmpty: "データが1件もありません",
    infoFiltered: "（全 _MAX_ 件より抽出）",
    infoPostFix: "",
    zeroRecords: "データが1件もありません",
    emptyTable: "データが1件もありません",
    paginate: {
      first: "最初",
      previous: "前",
      next: "次",
      last: "最後"
    }
  }
};

tableUtil.initDataTable = (table, columns, widths, renders = {}) => {
  let columnDefs = {};
  columnDefs = columns.map((column, i) => (
    {
      title: column,
      targets: i,
      data: i,
      className: 'align-middle text-center',
      width: widths[i]
    }
  ));
  Object.keys(renders).forEach(i => (columnDefs[i]['render'] = renders[i]));
  table.dataTable({
    ...myOptions,
    data: table.data('json'),
    columnDefs: columnDefs
  });
};

//
window.tableUtil = tableUtil;

