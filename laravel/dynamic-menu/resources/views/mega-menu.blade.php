@extends('layouts.blank')

@push('css')
    @vite(['resources/css/mega-menu.css', 'resources/css/nav.css'])
@endpush()

@section('content')
    <div class="navbar">

        @foreach ($categories as $category)
            <div class="dropdown">
                @if (is_null($category->parent_id))
                    <button class="dropbtn"> {{ $category->name }} <i class="fa fa-caret-down"></i> </button>
                @endif
                @if ($category->children)
                    <div class="dropdown-content">
                        <div class="row">
                            @foreach ($category->children as $child)
                                <div class="column">
                                    <h3>{{ $child->name }}</h3>
                                    @foreach ($child->children as $child)
                                        <a href="#">{{ $child->name }}</a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

    </div>
@endsection
