@extends('layouts.app')
@section('header')
    @include('parts.header')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ url('/holiday') }}">休暇申請登録</a>
                    </table>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>従業員ID</th>
                            <th>提出日</th>
                            <th>休暇種別コード</th>
                            <th>理由</th>
                            <th>備考</th>
                            <th>申請状況</th>
                        </tr>
                        @foreach(DB::table('holiday_applications')->get() as $row1)
                            <tr>
                                <td>{{$row1->id}}</td>
                                <td>{{$row1->employee_id}}</td>
                                <td>{{$row1->submit_date}}</td>
                                <td>{{$row1->holiday_class_common_id}}</td>
                                <td>{{$row1->reason}}</td>
                                <td>{{$row1->remarks}}</td>
                                <td>{{$row1->appliication_status}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <br>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>休暇届ID</th>
                            <th>休暇日</th>
                            <th>休暇時間(開始)</th>
                            <th>休暇時間(終了)</th>
                        </tr>
                        @foreach(DB::table('holiday_datetimes')->get() as $row2)
                            <tr>
                                <td>{{$row2->id}}</td>
                                <td>{{$row2->holiday_application_id}}</td>
                                <td>{{$row2->holiday_date}}</td>
                                <td>{{$row2->holiday_time_from}}</td>
                                <td>{{$row2->holiday_time_to}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
