@extends('layouts.app')
{{-- TODO: Post title --}}
@section('title', 'View post: ')

@section('content')
<div class="container">

    {{-- TODO: Session flashes --}}
    @if (Session::has('post_created'))
    <div class="alert alert-success">
        <p>Post created successfully!</span>
        </p>
    </div>
    @endif

    @if (Session::has('post_updated'))
    <div class="alert alert-success">
        <p>Post updated successfully!</span>
        </p>
    </div>
    @endif


    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            {{-- TODO: Title --}}
            <h1>{{$post->title}}</h1>

            <p class="small text-secondary mb-0">
                <i class="fas fa-user"></i>
                {{-- TODO: Author --}}
                <span>By {{$post->author == null ? "unknown" : $post->author->name}}</span>
            </p>
            <p class="small text-secondary mb-0">
                <i class="far fa-calendar-alt"></i>
                {{-- TODO: Date --}}
                <span>{{substr($post->created_at,0,10)}}</span>
            </p>

            <div class="mb-2">
                {{-- TODO: Read post categories from DB --}}
                @foreach ($post->categories as $category)
                    <a href="#" class="text-decoration-none">
                        <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>

            <p>
                <i>{{$post->description}}</i>
            </p>

            <p>
                {{$post->text}}
            </p>

            {{-- TODO: Link --}}
            <a href="{{route('posts.index')}}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>

        </div>

        <div class="col-12 col-md-4">
            <div class="float-lg-end">

                {{-- TODO: Links, policy --}}
                @if ($post->author != null && (Auth::user()->id == $post->author->id))
                <a role="button" class="btn btn-sm btn-primary" href="{{route('posts.edit',$post)}}"><i class="far fa-edit"></i> Edit post</a>
                @endif

                {{-- <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i class="far fa-trash-alt">
                    <span></i> Delete post</span>
                </button> --}}

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- TODO: Title --}}
                    Are you sure you want to delete post <strong>N/A</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        onclick="document.getElementById('delete-post-form').submit();"
                    >
                        Yes, delete this post
                    </button>

                    {{-- TODO: Route, directives --}}
                    <form id="delete-post-form" action="#" method="POST" class="d-none">

                    </form>
                </div>
            </div>
        </div>
    </div>

    <img
        id="cover_preview_image"
        {{-- TODO: Cover --}}
        @if (isset($post->cover_image_path))
            src="{{ '/storage/'.$post->cover_image_path }}"
        @else
            src="{{ asset('images/default_post_cover.jpg') }}"
        @endif

        alt="Cover preview"
        class="my-3"
    >

    <div class="mt-3">
        {{-- TODO: Post paragraphs --}}
         Lorem ipsum
    </div>
</div>
@endsection
