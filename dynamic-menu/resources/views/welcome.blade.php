<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- @vite('resources/css/app.css') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dynamic Menu</title>
</head>

<body>

    {{-- Dynamic Mega Menu --}}
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

</body>

</html>
