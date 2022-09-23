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
    {{-- {{ dd($categories) }} --}}
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

    {{-- Dynamic Heirarchical Tree  --}}
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-4">
                <ul id="tree1">
                    <p class="well" style="height:135px;"><strong>Initialization no parameters</strong>

                        <br /> <code>$('#tree1').treed();</code>

                    </p>
                    <li><a href="#">TECH</a>

                        <ul>
                            <li>Company Maintenance</li>
                            <li>Employees
                                <ul>
                                    <li>Reports
                                        <ul>
                                            <li>Report1</li>
                                            <li>Report2</li>
                                            <li>Report3</li>
                                        </ul>
                                    </li>
                                    <li>Employee Maint.</li>
                                </ul>
                            </li>
                            <li>Human Resources</li>
                        </ul>
                    </li>
                    <li>XRP
                        <ul>
                            <li>Company Maintenance</li>
                            <li>Employees
                                <ul>
                                    <li>Reports
                                        <ul>
                                            <li>Report1</li>
                                            <li>Report2</li>
                                            <li>Report3</li>
                                        </ul>
                                    </li>
                                    <li>Employee Maint.</li>
                                </ul>
                            </li>
                            <li>Human Resources</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <p class="well" style="height:135px;"><strong>Initialization optional parameters</strong>

                    <br /> <code>$('#tree2').treed({openedClass : 'glyphicon-folder-open', closedClass :
                        'glyphicon-folder-close'});</code>

                </p>
                <ul id="tree2">
                    <li><a href="#">TECH</a>

                        <ul>
                            <li>Company Maintenance</li>
                            <li>Employees
                                <ul>
                                    <li>Reports
                                        <ul>
                                            <li>Report1</li>
                                            <li>Report2</li>
                                            <li>Report3</li>
                                        </ul>
                                    </li>
                                    <li>Employee Maint.</li>
                                </ul>
                            </li>
                            <li>Human Resources</li>
                        </ul>
                    </li>
                    <li>XRP
                        <ul>
                            <li>Company Maintenance</li>
                            <li>Employees
                                <ul>
                                    <li>Reports
                                        <ul>
                                            <li>Report1</li>
                                            <li>Report2</li>
                                            <li>Report3</li>
                                        </ul>
                                    </li>
                                    <li>Employee Maint.</li>
                                </ul>
                            </li>
                            <li>Human Resources</li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>


</body>

</html>
