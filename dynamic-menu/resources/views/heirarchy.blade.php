@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="/resources/css/tree.css">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Heirarchical Levels') }}</div>

                    <div class="card-body">
                        <div style="display: block; width:100%">
                            <ul id="menu">
                                @foreach ($categories as $category)
                                    <x-category :category="$category" />
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
