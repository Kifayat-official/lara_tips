<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Dynamic Menu</title>
</head>

<body>
    <h1 class="text-3xl underline">Dynamic Menu</h1>
    <div>
        @foreach ($categories as $category)
            <p>{{ $category }}</p>
        @endforeach
    </div>
</body>

</html>
