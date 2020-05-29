@extends('layouts.app')
@section('content')
    <form method="post" action="{{ url('holiday')}}" autocomplete="off">
        <div class="container">
            <div class="form-horizontal">
                <!-- CSRF保護 -->
                @csrf
                <div class="row my-2">
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-2">区分</label>
                    </div>
                    <div class="col-4 col-sm-2 mx-2">
                        <select id="holiday_class_common_id" name="holiday_class_common_id" class="form-control">
                            @foreach(\App\HolidayClass::all() as $holidayClass)
                            <option value="{{ $holidayClass->id }}" @if(old('holiday_class_common_id')==$holidayClass->id )selected @endif>{{$holidayClass->class_content}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-3">期間</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-inline">
                            <input id="holiday_date_from" type="text" name="holiday_date_from" value="{{ old('holiday_date_from') }}" class="col-5 col-sm-3 form-control datepicker mx-2 @error('holiday_date_from') is-invalid @enderror">
                            <label> ～ </label>
                            <input id="holiday_date_to" type="text" name="holiday_date_to" value="{{ old('holiday_date_to')}}" class="col-5 col-sm-3 form-control datepicker mx-2 @error('holiday_date_to') is-invalid @enderror">

                            <div class="input-group my-2 col-5 col-sm-2 p-0 mx-2">
                                <input id="holiday_days" type="text" name="holiday_days" value="{{old('holiday_days')}}" readonly class="form-control">
                                <div class=" input-group-append">
                                    <span class="input-group-text">日間</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-3">時間</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-inline">
                            <input type="text" id="holiday_time_from" name="holiday_time_from" value="{{old('holiday_time_from')}}" class="col-5 col-sm-3 form-control timepicker mx-2 @error('holiday_time_from') is-invalid @enderror">
                            <label> ～ </label>
                            <input type="text" id="holiday_time_to" name="holiday_time_to" value="{{old('holiday_time_to')}}" class="col-5 col-sm-3 form-control timepicker mx-2 @error('holiday_time_to') is-invalid @enderror">
                            <div class="input-group my-2 col-5 col-sm-2 p-0 mx-2">
                                <input type="text" id="holiday_hours" name="holiday_hours" readonly class="form-control @error('holiday_hours') is-invalid @enderror">
                                <div class="input-group-append">
                                    <span class="input-group-text">時間</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-3">理由</label>
                    </div>
                    <div class="col-sm-7">
                        <textarea name="reason" class="form-control mx-2 @error('reason') is-invalid @enderror">{{old('reason')}}</textarea>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-3">備考</label>
                    </div>
                    <div class="col-sm-7">
                        <textarea name="remarks" class="form-control mx-2 @error('remarks') is-invalid @enderror">{{old('reason')}}</textarea>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-sm-2 offset-sm-2">
                        <button class="btn btn-primary btn-block" type="button" onClick="submit();">申請</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
@endsection