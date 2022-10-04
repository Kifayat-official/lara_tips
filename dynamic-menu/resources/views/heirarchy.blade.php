@extends('layouts.blank')

@push('css')
    @vite(['resources/css/heirarchy.css'])
@endpush()

@section('content')
    <ul class="tree">

        @foreach ($categories as $category)
            <li>
                {{-- {{ dd($category->children) }} --}}
                <label><a>{{ $category->name }}</a></label>
                <input checked="" value="" type="checkbox">
                @if ($category->children)
                    <ul>
                        @foreach ($category->children as $child)
                            <li>
                                <label>{{ $child->name }}</a></label>
                                <input checked="" value="" type="checkbox">
                                @if ($child->children)
                                    <ul>
                                        @foreach ($child->children as $child)
                                            <li>
                                                <label>{{ $child->name }}</a></label>
                                                <input checked="" value="" type="checkbox">
                                                @if ($child->children)
                                                    <ul>
                                                        @foreach ($child->children as $child)
                                                            <li>
                                                                <label>{{ $child->name }}</a></label>
                                                                <input checked="" value="" type="checkbox">
                                                                @if ($child->children)
                                                                    <ul>
                                                                        @foreach ($child->children as $child)
                                                                            <li>
                                                                                <label><a>{{ $child->name }}</a></label>
                                                                                <input checked="" id="menu14"
                                                                                    value="" type="checkbox">
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach

    </ul>
@endsection
