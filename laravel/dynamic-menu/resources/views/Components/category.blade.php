{{-- <li class="parent">
    <a href="#">{{ $category->name }} <span class="expand">»</span></a>
    <x-categories :categories="$category->children" />
</li> --}}


<button class="dropbtn"> {{ $category->name }} <i class="fa fa-caret-down"></i> </button>
<x-categories :categories="$category->children" />
