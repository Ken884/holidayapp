@extends('layouts.app')
@section('content')
<div class="container">
  <div class="section-header">
    <h3>経費精算書：詳細</h3>
  </div>
  <div class="card">
    <div class="card-body">
      <form id="expense_show" data-href="{{ route('expense_authorize', $expenseApplication) }}">
        <div class="form-horizontal">
          <!-- CSRF保護 -->
          @csrf
          <div class="row form-group">
            <div class="col-sm-1 offset-sm-9 my-2">
              <label>提出日</label>
            </div>
            <div class="col-sm-2">
              <input type="text" id="submit_datetime" value="{{ DateTimeHelper::parseDate($expenseApplication->submit_datetime) }}" class="form-control mr-2" readonly>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover no-margin">
            <thead>
              <tr>
                <th style="width:10%">No.</th>
                <th style="width:15%">発生日</th>
                <th style="width:40%">支払明細</th>
                <th style="width:20%">種別</th>
                <th style="width:10%">金額</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($statements as $statement)
              <tr>
                <div hidden><input name='expense_id' value="{{ $expenseApplication->id }}"></div>
                <div hidden><input class="ex-authorization"></div>
                <div class="form-group form-group-norrow" class="form-control">
                  <td><input type="text" name="statement_number[]" value="{{ $statement->statement_number }}" readonly class="form-control text-right" readonly></td>
                  <td><input type="text" name="occurred_date[]" value="{{ $statement->occurred_date }}" class="form-control" readonly></td>
                  <td><textarea style="width:100%" name="statement[]" class="form-control" readonly>{{ $statement->statement }}</textarea></td>
                  <td><input name="expense_type_id[]" value="{{ $statement->expense_type->expense_type_name }}" class="form-control" readonly></td>
                  <td><input type="text" value="{{ $statement->amount }}" name="amount[]" class="form-control text-right" readonly></td>
                </div>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="row my-2">
          <div class="col-sm-1 ml-2">
            <label>備考</label>
          </div>
          <div class="col-sm-10">
            <textarea name="remarks" style="width:100%" class="form-control my-2" readonly>{{ $expenseApplication->remarks }}</textarea>
          </div>
        </div>
        <div class="row my-4">
          @can('edit_expense', $expenseApplication)
          <div class="col-sm-2 offset-sm-5">
            <a href="{{ route('expense_edit', $expenseApplication) }}"><button class="btn btn-primary btn-block edit" type="button">修正</button></a>
          </div>
          @elsecan('admin')
          <div class="col-sm-2 offset-sm-4">
            <button type="button" class="btn btn-primary btn-block ex-authorize @if($expenseApplication->application_status->application_status_code == 'approve') disabled @endif">承認</button>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-danger btn-block ex-decline @if($expenseApplication->application_status->application_status_code == 'deny') disabled @endif">否認</button>
          </div>
          @endcan
        </div>
      </form>
    </div>
  </div>
</div>
@endsection