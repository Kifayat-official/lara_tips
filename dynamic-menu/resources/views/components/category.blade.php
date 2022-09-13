<div class="flex items-center">
    @if ($category->isChild())
    @endif
    <div class="bg-white px-8 py-4 rounded shadow flex-1">{{ $category->name }}</div>
</div>

<x-categories :categories="$category->children" />
