<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- @vite('resources/css/app.css') --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dynamic Menu</title>
</head>

<body>

    {{-- @foreach ($categories->child as $cat)
        <div>{{ $cat->name }}</div>
    @endforeach --}}


    <div class="menu-bar">
        <h1 class="logo">Lara<span> gigs.</span></h1>
        <ul>
            @foreach ($categories as $category)
                <li>
                    <a href="#">{{ $category->name }} <i class="fas fa-caret-down"></i></a>

                    @foreach ($category->children as $child)
                        <div class="dropdown-menu">
                            <ul>
                                @foreach ($child->children as $child1)
                                    <li>
                                        <a href="#">{{ $child1->name }} <i class="fas fa-caret-right"></i></a>


                                        <div class="dropdown-menu-1">
                                            <ul>
                                                @foreach ($child1->children as $child2)
                                                    <li><a href="#">{{ $child2->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    @endforeach

                </li>
            @endforeach
        </ul>
    </div>

    <div class="hero">
        &nbsp;
    </div>





    {{-- <div class="menu-bar">
        <h1 class="logo">Lara<span> gigs.</span></h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Pages <i class="fas fa-caret-down"></i></a>

                <div class="dropdown-menu">
                    <ul>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Portfolio</a></li>
                        <li>
                            <a href="#">Team <i class="fas fa-caret-right"></i></a>

                            <div class="dropdown-menu-1">
                                <ul>
                                    <li><a href="#">Team-1</a></li>
                                    <li><a href="#">Team-2</a></li>
                                    <li><a href="#">Team-3</a></li>
                                    <li><a href="#">Team-4</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">Blog</a>
            </li>
            <li><a href="#">Contact us</a></li>
        </ul>
    </div>

    <div class="hero">
        &nbsp;
    </div> --}}

</body>

</html>
