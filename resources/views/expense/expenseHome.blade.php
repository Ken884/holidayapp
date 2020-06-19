@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-tabs">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                            Holiday Dashboard
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
                                    <th>休暇種別</th>
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
        </div>
    </div>
</div>
@endsection