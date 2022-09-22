<div class="dropdown-content">
    <div class="row">
        @foreach ($categories as $child)
            <div class="column">
                <h3>{{ $child->name }}</h3>
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
                {{-- <x-category :category="$child" /> --}}
            </div>
        @endforeach
    </div>
</div>
