<li class="parent">
    <a href="#">{{ $category->name }} <span class="expand">»</span></a>
    <x-categories :categories="$category->children" />
</li>
