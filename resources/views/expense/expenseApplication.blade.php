@extends('layouts.app')
@section('content')
<div class="container">
    @if($mode == 'new')
    <div class="section-header"><h3>経費精算書：新規</h3></div>
    @else
    <div class="section-header"><h3>経費精算書：修正</h3></div>
    @endif
    <div class="card">
        <div class="card-body">
            <form id="expense_application" method="post" action="{{ url('/expenseapplications/new')}}" autocomplete="off">

                <div class="form-horizontal">
                    <!-- CSRF保護 -->
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-1 offset-sm-9 my-2">
                            <label>提出日</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="submit_datetime" style="text-align:center" name="submit_datetime" class="form-control mr-2" readonly>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover no-margin dynamic-table">
                        <thead>
                            <tr>
                                <th class="v-center" style="width:10%">No.</th>
                                <th class="v-center" style="width:15%">発生日</th>
                                <th class="v-center" style="width:40%">支払明細</th>
                                <th class="v-center" style="width:20%">種別</th>
                                <th class="v-center" style="width:10%">金額</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none template">
                                <div class="form-group form-group-norrow" class="form-control">
                                    <div><input name="expense_id" value="{{ $expenseApplication->id }}" data-mode="{{ $mode }}"hidden></div>
                                    <td><input type="text" name="statement_number[]" readonly class="form-control dynamic-num" disabled></td>
                                    <td><input type="text" name="occurred_date[]" class="e-datepicker form-control dynamic-dp" disabled></td>
                                    <td><textarea style="width:100%" name="statement[]" class="form-control" disabled></textarea></td>
                                    <td><select name="expense_type_id[]" style="width:100%" class="form-control" disabled>
                                            @foreach(App\ExpenseType::all() as $expense)
                                            <option value="{{ $expense->id }}">{{ $expense->expense_type_name }}
                                            </option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="text" name="amount[]" class="form-control" disabled></td>
                                </div>
                            </tr>
                            @if(!$errors->any())
                            @foreach($expenseApplication->expense_statements as $statement)
                            <tr>
                                    <td><input type="text" name="statement_number[]" value="{{ $statement->statement_numbar }}" class="form-control" readonly></td>
                                    <td><input type="text" name="occurred_date[]" value="{{ $statement->occurred_date }}" class="e-datepicker form-control"></td>
                                    <td><textarea style="width:100%" name="statement[]" class="form-control">{{ $statement->statement }}</textarea></td>
                                    <td><select name="expense_type_id[]" style="width:100%" class="form-control">
                                            @foreach(App\ExpenseType::all() as $expense)
                                            <option value="{{ $expense->id }}" @if( $statement->expense_type_id==$expense->id ) selected @endif>{{ $expense->expense_type_name }}</option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="text" value="{{ $statement->amount }}" name="amount[]" class="form-control"></td>
                            </tr>
                            @endforeach
                            @elseif($errors->any())
                            @for($i = 0; $i < count(old('statement_number', [])); $i++) <tr>
                                <td><input type="text" name="statement_number[]" value="{{ old('statement_number.' . $i) }}" class="form-control" readonly></td>
                                <td><input type="text" name="occurred_date[]" value="{{ old('occurred_date.' . $i) }}" class="e-datepicker form-control @error('occurred_date.' . $i) is-invalid @enderror">
                                @error('occurred_date.' . $i)<div class="text-danger">{{ $message }}</div>  @enderror</td>
                                <td><textarea style="width:100%" name="statement[]" class="form-control @error('statement.' . $i) is-invalid @enderror">{{ old('statement.'. $i) }}</textarea>
                                @error('statement.' . $i)<div class="text-danger">{{ $message }}</div>  @enderror</td>
                                <td><select name="expense_type_id[]" style="width:100%" class="form-control ">
                                        @foreach(App\ExpenseType::all() as $expense)
                                        <option value="{{ $expense->id }}" @if(old('expense_type_id.' . $i)==$expense->id )selected @endif>{{ $expense->expense_type_name }}</option>
                                        @endforeach
                                    </select></td>
                                <td><input type="text" value="{{ old('amount.' . $i) }}" name="amount[]" class="form-control @error('amount.' . $i) is-invalid @enderror">
                                @error('amount.' . $i)<div class="text-danger">{{ $message }}</div>  @enderror</td>
                                </tr>
                                @endfor
                                @endif
                        </tbody>
                    </table>
                </div>
                <div class="row my-2">
                    <div class="col-sm-1 ml-2">
                        <label>備考</label>
                    </div>
                    <div class="col-sm-10">
                        <textarea name="remarks" style="width:100%" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-2 offset-sm-5">
                        <button id="submit_expense" type="submit" class="btn btn-primary btn-block" type="button">申請</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection