<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hello {{$name}}!</h1>
    <p>You teach the following classes:</p>
    <ul>
        @foreach ($classes as $class)
            <li>{{$class}}</li>            
        @endforeach
    </ul>
</body>
</html>