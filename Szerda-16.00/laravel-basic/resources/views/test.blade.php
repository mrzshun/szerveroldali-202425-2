
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>Hello world!</h1>
    <p>
        @if ($id == -1)
            The ID was not provided.
        @else
            The id is: {{$id}}
        @endif
        <br/>
        The name is: {{$name}} == <?php echo $name ?>
    </p>
    <ul>
        @foreach ($to_iterate as $item)
            <li>{{$item}}</li>
        @endforeach
    </ul>

</body>
</html>
