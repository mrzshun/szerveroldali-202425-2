<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog test</title>
</head>
<body>
    <h1>Blogposts</h1>
    @foreach ($posts as $post)
        <h2>{{$post->title}}</h2>
        @foreach ($post->categories as $category)
            <span style="color: {{$category->txt_color}};background-color:{{$category->bg_color}}">{{$category->name}}</span>
        @endforeach
        <br>
        <cite>Author: {{$post->author == null ? "unknown" : $post->author->name}}</cite>
        <p>{{$post->description}}</p>
    @endforeach
</body>
</html>