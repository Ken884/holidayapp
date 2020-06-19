@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1">
                            ダッシュボード
                        </a>
                    </li>
                    @can('admin')
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2">
                            管理者用画面
                        </a>
                    </li>
                    @endcan
                </ul>

                <div class="tab-content">
                    <div class="chart tab-pane active" id="tab1">
                        <!-- userの内容 -->
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">Information</div>
                                <div class="card-body">
                                    <p>これから考える</p>
                                    <a href="{{ route('holiday_create') }}"><button class="btn btn-primary">新規作成</button></a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">Recents</div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>ID</th>
                                            <th>従業員ID</th>
                                            <th>提出日</th>
                                            <th>休暇種別</th>
                                            <th>理由</th>
                                            <th>備考</th>
                                            <th>申請状況</th>
                                            <th></th>
                                        </tr>

                                        @foreach($holidayApplications->get() as $holidayApplication)
                                        <tr>
                                            <td>{{ $holidayApplication->id }}</td>
                                            <td>{{ $holidayApplication->employee_id }}</td>
                                            <td>{{ $holidayApplication->submit_datetime }}</td>
                                            <td>{{ $holidayApplication->holiday_type->holiday_type_name }}</td>
                                            <td>{{ $holidayApplication->reason }}</td>
                                            <td>{{ $holidayApplication->remarks }}</td>
                                            <td>{{ $holidayApplication->application_status->application_status_name }}</td>
                                            <td><a href="{{  route('holiday_show', $holidayApplication) }}"><button class="btn btn-success">詳細</button></a></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @can('admin')
                    <div class="chart tab-pane " id="tab2">
                        <!-- adminの内容 -->
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">Recents</div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>ID</th>
                                            <th>従業員ID</th>
                                            <th>提出日</th>
                                            <th>休暇種別</th>
                                            <th>理由</th>
                                            <th>備考</th>
                                            <th>申請状況</th>
                                            <th></th>
                                        </tr>

                                        @foreach($holidayApplications->get() as $holidayApplication)
                                        <tr>
                                            <td>{{ $holidayApplication->id }}</td>
                                            <td>{{ $holidayApplication->employee_id }}</td>
                                            <td>{{ $holidayApplication->submit_datetime }}</td>
                                            <td>{{ $holidayApplication->holiday_type->holiday_type_name }}</td>
                                            <td>{{ $holidayApplication->reason }}</td>
                                            <td>{{ $holidayApplication->remarks }}</td>
                                            <td>{{ $holidayApplication->application_status->application_status_name }}</td>
                                            <td><a href="{{  route('holiday_show', $holidayApplication) }}"><button class="btn btn-success">詳細</button></a></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection