<ul class="child">
    @foreach ($categories as $child)
        <li class="parent">
            <x-category :category="$child" />
        </li>
    @endforeach
</ul>
