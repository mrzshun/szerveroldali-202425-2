@extends('layouts.app')
{{-- TODO: Post title --}}
@section('title', 'View post: ')

@section('content')
    <div class="container">

        @if (Session::has('post_created'))
            <div class="alert alert-success">
                <p>
                    The post was successfully created.
                </p>
            </div>
        @endif
        @if (Session::has('post_updated'))
            <div class="alert alert-success">
                <p>
                    The post was successfully updated.
                </p>
            </div>
        @endif

        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                {{-- TODO: Title --}}
                <h1>{{ $post->title }}</h1>

                <p class="small text-secondary mb-0">
                    <i class="fas fa-user"></i>
                    {{-- TODO: Author --}}
                    <span>{{ $post->author ? $post->author->name : 'unknown' }}</span>
                </p>
                <p class="small text-secondary mb-0">
                    <i class="far fa-calendar-alt"></i>
                    {{-- TODO: Date --}}
                    <span>{{ substr($post->created_at, 0, 10) }}</span>
                </p>

                <div class="mb-2">
                    {{-- TODO: Read post categories from DB --}}
                    @foreach ($post->categories as $category)
                        <a href="#" class="text-decoration-none">
                            <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- TODO: Link --}}
                <a href="#"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>

            </div>

            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    {{-- TODO: Links, policy --}}
                    @can('update', $post)
                    <a role="button" class="btn btn-sm btn-primary" href="{{ route('posts.edit', $post) }}"><i
                        class="far fa-edit"></i> Edit
                        post</a>
                    @endcan

                    @can('delete', $post)
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i
                                class="far fa-trash-alt">
                                <span></i> Delete post</span>
                        </button>
                    @endcan

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
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
                        <button type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete-post-form').submit();">
                            Yes, delete this post
                        </button>

                        {{-- TODO: Route, directives --}}
                        <form id="delete-post-form" action="{{ route('posts.destroy', $post) }}" method="POST"
                            class="d-none">
                            @method('DELETE')
                            @csrf

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <img id="cover_preview_image" {{-- TODO: Cover --}}
            src="{{ isset($post->cover_image_path) ? '/storage/' . $post->cover_image_path : asset('images/default_post_cover.jpg') }}"
            alt="Cover preview" class="my-3" width="300px">

        <div class="mt-3">
            <p><i>
                    {{ $post->description }}
                </i>
            </p>
            <p>
                {{ $post->text }}
            </p>
        </div>
    </div>
@endsection
