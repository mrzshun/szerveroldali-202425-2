@extends('layouts.app')
@section('title', 'Posts')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>All posts</h1>
        </div>
        <div class="col-12 col-md-4">
            <div class="float-lg-end">
                {{-- TODO: Links, policy --}}

                <a href="{{route('posts.create')}}" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i> Create post</a>

                <a href="{{route('categories.create')}}" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i> Create category</a>

            </div>
        </div>
    </div>

    {{-- TODO: Session flashes --}}
    @if (Session::has('cannot_delete_post'))
        <div class="alert alert-success">
            <p>You cannot delete the following post: {{ session('cannot_delete_post') }}</p>
        </div>
    @endif
    @if (Session::has('post_deleted'))
        <div class="alert alert-success">
            <p>The post is successfully deleted: {{ session('post_deleted') }}</p>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-12 col-lg-9">
            <div class="row">
                {{-- TODO: Read posts from DB --}}

                @forelse ($posts as $post)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch">
                        <div class="card w-100">
                            <img
                            @if (isset($post->cover_image_path))
                                src="{{ 'storage/'.$post->cover_image_path }}"
                            @else
                                src="{{ asset('images/default_post_cover.jpg') }}"
                            @endif
                                
                                class="card-img-top"
                                alt="Post cover"
                            >
                            <div class="card-body">
                                {{-- TODO: Title --}}
                                <h5 class="card-title mb-0">{{$post->title}}</h5>
                                <p class="small mb-0">
                                    <span class="me-2">
                                        <i class="fas fa-user"></i>
                                        {{-- TODO: Author --}}
                                        <span>By {{$post->author == null ? "unknown" : $post->author->name}}</span>
                                    </span>

                                    <span>
                                        <i class="far fa-calendar-alt"></i>
                                        {{-- TODO: Date --}}
                                        <span>{{substr($post->created_at,0,10)}}</span>
                                    </span>
                                </p>

                                {{-- TODO: Read post categories from DB --}}
                                @foreach ($post->categories as $category)
                                    <a href="#" class="text-decoration-none">
                                        <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                                    </a>
                                @endforeach

                                {{-- TODO: Short desc --}}
                                <p class="card-text mt-1">{{$post->description}}</p>
                            </div>
                            <div class="card-footer">
                                {{-- TODO: Link --}}
                                <a href="{{route('posts.show',$post)}}" class="btn btn-primary">
                                    <span>View post</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No posts found!
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center">
                {{$posts->links()}}
            </div>

        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-header">
                            Categories
                        </div>
                        <div class="card-body">
                            {{-- TODO: Read categories from DB --}}
                            @foreach ($categories as $category)
                                <a href="#" class="text-decoration-none">
                                    <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-header">
                            Statistics
                        </div>
                        <div class="card-body">
                            <div class="small">
                                <ul class="fa-ul">
                                    {{-- TODO: Read stats from DB --}}
                                    <li><span class="fa-li"><i class="fas fa-user"></i></span>Users: {{$users->count()}}</li>
                                    <li><span class="fa-li"><i class="fas fa-layer-group"></i></span>Categories: {{$categories->count()}}</li>
                                    <li><span class="fa-li"><i class="fas fa-file-alt"></i></span>Posts: {{$posts->count()}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
