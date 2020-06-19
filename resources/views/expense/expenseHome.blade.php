@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="nav-tabs-custom">
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
                                        <a href="{{ route('expense_create') }}"><button class="btn btn-primary">新規作成</button></a>
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
                                                <th>申請状況</th>
                                                <th></th>
                                            </tr>

                                            @foreach($expenseApplications->get() as $expenseApplication)
                                            <tr>
                                                <td>{{ $expenseApplication->id }}</td>
                                                <td>{{ $expenseApplication->employee_id }}</td>
                                                <td>{{ $expenseApplication->submit_datetime }}</td>
                                                <td>{{ $expenseApplication->application_status->application_status_name }}</td>
                                                <td><a href="{{  route('expense_show', $expenseApplication) }}"><button class="btn btn-success">詳細</button></a></td>
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
                                                <th>申請状況</th>
                                                <th></th>
                                            </tr>
                                            @foreach(App\ExpenseApplication::all() as $expenseApplication)
                                            <tr>
                                                <td>{{ $expenseApplication->id }}</td>
                                                <td>{{ $expenseApplication->employee_id }}</td>
                                                <td>{{ $expenseApplication->submit_datetime }}</td>
                                                <td>{{ $expenseApplication->application_status->application_status_name }}</td>
                                                <td><a href="{{  route('expense_show', $expenseApplication) }}"><button class="btn btn-success">詳細</button></a></td>
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