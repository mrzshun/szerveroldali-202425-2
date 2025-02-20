<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
    @if ($id == -1)
        <h1>Hello unknown stranger!</h1>
    @else
        <h1>Hello {{$id}}</h1>        
    @endif
</body>
</html>