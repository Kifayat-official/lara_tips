<div class="navbar">
    <div class="dropdown">
        @foreach ($categories as $category)
            <x-category :category="$category" />
        @endforeach
    </div>
</div>
