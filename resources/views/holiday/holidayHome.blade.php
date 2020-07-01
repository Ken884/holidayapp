@extends('layouts.app')
@section('content')
<div class="container">
    <div class="section-header">
        <h3>休暇届：一覧</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1">
                            <h5>あなたの休暇届一覧</h5>
                        </a>
                    </li>
                    @can('admin')
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2">
                            <h5>みんなの休暇届一覧</h5>
                        </a>
                    </li>
                    @endcan
                </ul>

                <div class="tab-content">
                    <div class="chart tab-pane active" id="tab1">
                        <!-- userの内容 -->
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">ダッシュボード</div>
                                <div class="card-body">
                                    <div class="row my-2">
                                        <div class="col-sm-3 offset-1 mr-3">
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>{{ $info['days'] }}日</h3>
                                                    <p>休暇取得日数</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    <span>more info</span>
                                                    <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 mx-3">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h3>{{ $info['approved'] }}件</h3>
                                                    <p>承認された休暇届</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-chart-bar"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    <span>more info</span>
                                                    <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 mx-3">
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>{{ $info['denied'] }}件</h3>
                                                    <p>否認された休暇届</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-chart-bar"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    <span>more info</span>
                                                    <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-sm-4 offset-sm-4">
                                            <a href="{{ route('holiday_create') }}"><button class="btn btn-primary btn-block">新規作成</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">一覧</div>
                                <div class="card-body">
                                    <form id="userSearchHoliday">
                                        <div class="form-group">
                                            <div class="row my-2">
                                                <div class="col-sm-1"><label>申請状況</label></div>
                                                <div class="col-sm-3">
                                                    <select name="appStatus" class="form-control">
                                                        @foreach(App\ApplicationStatus::all() as $appStatus)
                                                        <option value="{{ $appStatus->id }}">{{ $appStatus->application_status_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-1"><label>提出日</label></div>

                                                <div class="col-sm-3">
                                                    <input type="text" name="submitDate" class="hh-datepicker form-control">
                                                </div>
                                                <div class="col-sm-2 ml-3 float-right">
                                                    <input type="button" value="絞り込み" id="showUserHoliday" class="btn btn-primary btn-block">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-striped table-bordered ho-user" data-json="{{ $holidayApplications }}">
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
                                <div class="card-body">
                                    <form id="adminSearchHoliday">
                                        <div class="form-group">
                                            <div class="row my-2">
                                                <div class="col-sm-1"><label>申請状況</label></div>
                                                <div class="col-sm-3">
                                                    <select name="appStatus" class="form-control">
                                                        @foreach(App\ApplicationStatus::all() as $appStatus)
                                                        <option value="{{ $appStatus->id }}">{{ $appStatus->application_status_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-1"><label>提出日</label></div>

                                                <div class="col-sm-3">
                                                    <input type="text" name="submitDate" class="hh-datepicker form-control">
                                                </div>
                                                <div class="col-sm-2 ml-3 float-right">
                                                    <input type="button" value="絞り込み" id="showAdminHoliday" class="btn btn-primary btn-block">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-striped table-bordered ho-admin" data-json="{{ $listForAdmin }}">
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