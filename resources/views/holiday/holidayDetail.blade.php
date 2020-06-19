@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row my-2">
                <div class="col-sm-1 offset-sm-2">
                    <label class="mt-2">区分</label>
                </div>
                <div class="col-4 col-sm-2 my-2 mx-2">
                    <input type="text" id="holiday_class" name="holiday_class" value="{{ $holidayApplication->holiday_type->holiday_type_name}}" class="form-control"readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 offset-sm-2">
                    <label class="mt-3">期間</label>
                </div>
                <div class="col-sm-9">
                    <div class="form-inline" id="holiday_date">
                        <input id="first_date" type="text" name="holiday_date_from" 
                        value="{{ $datetime->sortBy('holiday_date')->first()->holiday_date }}" readonly class="col-5 col-sm-3 form-control mx-2">
                        <label> ～ </label>
                        <input id="last_date" type="text" name="holiday_date_to" 
                        value="{{ $datetime->sortBy('holiday_date')->last()->holiday_date }}" readonly class="col-5 col-sm-3 form-control mx-2">

                        <div class="input-group my-2 col-5 col-sm-2 p-0 mx-2">
                            <input id="holiday_days" type="text" name="holiday_days" value="" readonly class="form-control">
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
                        <input id="holiday_time_from" name="holiday_time_from" value="{{ $datetime->first()->holiday_time_from }}" readonly class="col-5 col-sm-3 form-control mx-2">
                        <label> ～ </label>
                        <input id="holiday_time_to" name="holiday_time_to" value="{{ $datetime->first()->holiday_time_to }}" readonly class="col-5 col-sm-3 form-control  mx-2">
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
                    <textarea name="reason" class="form-control my-2 mx-2" readonly>{{ $holidayApplication->reason }}</textarea>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-sm-1 offset-sm-2">
                    <label class="mt-3">備考</label>
                </div>
                <div class="col-sm-7">
                    <textarea name="remarks" class="form-control my-2 mx-2" readonly>{{ $holidayApplication->remarks }}</textarea>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-sm-2 offset-sm-5">
                    <a href="#"><button id="notyet" class="btn btn-primary btn-block" type="button">修正</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection