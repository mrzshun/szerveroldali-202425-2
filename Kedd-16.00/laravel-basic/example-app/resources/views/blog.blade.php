<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
</head>
<body>
    {{-- @if ($post == null)
        <h1>There is no post with the given id ({{$id}})!</h1>
    @else
        <h2>{{$post["title"]}}</h2>
        <p>{{$post["description"]}}</p>    
    @endif --}}
    <h1>Blogposts:</h1>
    @foreach ($posts as $post)
        <h2>{{$post["title"]}}</h2>
        <p>{{$post["description"]}}</p>
    @endforeach
</body>
</html>