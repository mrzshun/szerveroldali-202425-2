<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
</head>
<body>
    <h1>Blogposts</h1>
    <p>The number of blogposts are: {{$posts->count()}}</p>
    @foreach ($posts as $post)
        <h2>{{$post->title}}</h2>
        <p><cite>Author: {{$post->author ? $post->author->name : 'unknown'}}</cite></p>
        <p>
            @foreach ($post->categories as $category)
                <span style="color:{{$category->bg_color}};background-color:{{$category->txt_color}}">{{$category->name}}</span>
            @endforeach
        </p>
        <p>{{$post->description}}</p>
    @endforeach
</body>
</html>