@extends('layouts.app')
@section('content')
<div class="container">
    @if($mode == 'new')
    <div class="section-header">
        <h3>休暇届：新規</h3>
    </div>
    @else
    <div class="section-header">
        <h3>休暇届：修正</h3>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form id="holiday_application" method="post" action="{{ url('holidayapplications/new')}}" autocomplete="off" data-mode>
                <div class="form-horizontal">
                    <!-- CSRF保護 -->
                    @csrf
                    <div hidden><input name="holiday_id" value="{{ $holidayApplication->id }}" data-mode="{{ $mode }}"></div>
                    <div class="row my-2">
                        <div class="col-sm-1 offset-sm-2">
                            <label class="mt-2">種別</label>
                        </div>
                        <div class="col-4 col-sm-2 my-2 mx-2">
                            <select id="holiday_type_id" name="holiday_type_id" class="form-control">
                                @foreach(\App\HolidayType::all() as $holiday_type)
                                <option value="{{ $holiday_type->id }}" @if(old('holiday_type_id')==$holiday_type->id )selected @endif>{{$holiday_type->holiday_type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 offset-sm-2">
                            <label class="mt-3">期間</label>
                        </div>
                        <div class="col-sm-9">
                            <div id="yasumi" data-json="{{ $yasumiArray }}" hidden></div>
                            <div class="form-inline" id="holiday_date">
                                <input id="holiday_date_from" type="text" name="holiday_date_from" value="{{ DateTimeHelper::parseDate(old('holiday_date_from')) }}" class="col-5 col-sm-3 form-control ha-datepicker mx-2 @error('holiday_date_from') is-invalid @enderror">
                                <label> ～ </label>
                                <input id="holiday_date_to" type="text" name="holiday_date_to" value="{{ DateTimeHelper::parseDate(old('holiday_date_to')) }}" class="col-5 col-sm-3 form-control ha-datepicker mx-2 @error('holiday_date_to') is-invalid @enderror">

                                <div class="input-group my-2 col-5 col-sm-2 p-0 mx-2">
                                    <input id="holiday_days" type="text" name="holiday_days" value="{{ old('holiday_days')}}" readonly class="form-control">
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
                                <select id="holiday_time_from" name="holiday_time_from" data-old="{{ old('holiday_time_from') }}" class="col-5 col-sm-3 form-control timepicker mx-2 @error('holiday_time_from') is-invalid @enderror">
                                    <option value=""></option>
                                </select>
                                <label> ～ </label>
                                <select id="holiday_time_to" name="holiday_time_to" data-old="{{ old('holiday_time_to') }}" class="col-5 col-sm-3 form-control timepicker mx-2 @error('holiday_time_to') is-invalid @enderror">
                                    <option value=""></option>
                                </select>
                                <div class="input-group my-2 col-5 col-sm-2 p-0 mx-2">
                                    <input type="text" id="holiday_hours" name="holiday_hours" readonly class="form-control ">
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
                            <textarea name="reason" class="form-control my-2 mx-2 @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-1 offset-sm-2">
                            <label class="mt-3">備考</label>
                        </div>
                        <div class="col-sm-7">
                            <textarea name="remarks" class="form-control my-2 mx-2 @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-sm-2 offset-sm-2">
                            <button id="submit_holiday" class="btn btn-primary btn-block" type="button">申請</button>
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
        </div>
    </div>
</div>
@endsection