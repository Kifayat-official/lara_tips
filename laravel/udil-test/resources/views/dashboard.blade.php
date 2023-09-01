@extends('adminlte::page')

@section('content_header')
    <h1>
        Dashboard
    </h1>

    <ul>
    <li>PHP: {{ phpversion() }}</li>
    <li>Laravel: {{ app()->version() }}</li>
</ul>
@stop

@section('content')

<div class="row">

    <div class="col-md-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $tests->where('is_finished', 1)->count() }}</h3>
                <p>Completed Tests</p>
            </div>
            <div class="icon">
                <i class="fa fa-stop-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $tests->where('is_finished', 0)->count() }}</h3>
                <p>Tests in Progress</p>
            </div>
            <div class="icon">
                <i class="fa fa-play-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $tests->where('is_pass', 1)->count() }}</h3>
                <p>Passed Tests</p>
            </div>
            <div class="icon">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box bg-red">
            <div class="inner">
            <h3>{{ $tests->where('is_pass', 0)->count() }}</h3>
                <p>Failed Tests</p>
            </div>
            <div class="icon">
                <i class="fa fa-times-circle"></i>
            </div>
        </div>
    </div>

</div>
    
@stop
