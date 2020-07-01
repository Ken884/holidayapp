@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-tabs">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                            Your Dashboard
                        </a>
                    </li>
                </ul>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">休暇申請一覧</div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th style="width:5%">ID</th>
                                    <th style="width:10%">従業員ID</th>
                                    <th style="width:10%">提出日</th>
                                    <th style="width:10%">休暇種別</th>
                                    <th style="width:20%">理由</th>
                                    <th style="width:20%">備考</th>
                                    <th style="width:10%">申請状況</th>
                                </tr>
                                @foreach(App\HolidayApplication::all() as $row1)
                                <tr>
                                    <td>{{$row1->id}}</td>
                                    <td>{{$row1->employee_id}}</td>
                                    <td>{{ DateTimeHelper::parseDate($row1->submit_datetime) }}</td>
                                    <td>{{$row1->holiday_type->holiday_type_name}}</td>
                                    <td>{{$row1->reason}}</td>
                                    <td>{{$row1->remarks}}</td>
                                    <td>{{$row1->application_status->application_status_name}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection