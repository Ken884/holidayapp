@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form id="holiday_show" data-href="{{ route('holiday_authorize', $holidayApplication) }}">
                <!-- CSRF保護 -->
                @csrf
                <div class="row my-2">
                    <div hidden><input name="holiday_id" value="{{ $holidayApplication->id }}"></div>
                    <div hidden><input class="ho-authorization"></div>
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-3">区分</label>
                    </div>
                    <div class="col-4 col-sm-2 my-2 mx-2">
                        <input type="text" id="holiday_class" name="holiday_class" value="{{ $holidayApplication->holiday_type->holiday_type_name}}" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1 offset-sm-2">
                        <label class="mt-3">期間</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-inline" id="holiday_date">
                            <input id="first_date" type="text" name="holiday_date_from" value="{{ $datetime->sortBy('holiday_date')->first()->holiday_date }}" readonly class="col-5 col-sm-3 form-control mx-2">
                            <label> ～ </label>
                            <input id="last_date" type="text" name="holiday_date_to" value="{{ $datetime->sortBy('holiday_date')->last()->holiday_date }}" readonly class="col-5 col-sm-3 form-control mx-2">

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
                <div class="row my-2">
                    @can('edit_holiday', $holidayApplication)
                    <div class="col-sm-2 offset-sm-5">
                        <a href="{{ route('holiday_edit', $holidayApplication) }}"><button class="btn btn-primary btn-block edit" type="button">修正</button></a>
                    </div>
                    @elsecan('admin')
                    <div class="col-sm-2 offset-sm-4">
                        <button type="button" class="btn btn-primary btn-block ho-authorize @if($holidayApplication->application_status->application_status_code == 'approve') disabled @endif">承認</button>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-danger btn-block ho-decline @if($holidayApplication->application_status->application_status_code == 'deny') disabled @endif">否認</button>
                    </div>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endsection