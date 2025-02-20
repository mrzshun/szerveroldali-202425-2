<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
</head>
<body>
    @if ($post != null)
        <h1>The requested blogpost:</h1>
        <h2>{{$post['title']}}</h2>
        <cite>{{$post['author']}}</cite>
        <p> <strong>{{$post['description']}}</strong></p>
        <p>{{$post['text']}}</p>
    @elseif ($post == null && $id != -1)
        <h1>The requested blogpost does not exist!</h1>
    @elseif (collect($posts)->count()==0)
        <h1>There are no blogposts!</h1>
    @else
        <h1>All blogposts:</h1>
        @foreach ($posts as $post)
            <h2>{{$post['title']}}</h2>
            <cite>{{$post['author']}}</cite>
            <p>{{$post['description']}}</p>
            <p><a href="./{{$post['id']}}">Details</a></p>
        @endforeach
    @endif
</body>
</html>