@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-tabs">
                <div class="card-header"></div>
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection