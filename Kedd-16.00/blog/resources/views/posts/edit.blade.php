@extends('layouts.app')
@section('title', 'Create post')

@section('content')
    <div class="container">
        <h1>Edit post</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="#"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        {{-- TODO: action, method, enctype --}}
        <form method="post" action="{{ route('posts.update',$post) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            {{-- TODO: Validation --}}

            <div class="form-group row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title',$post->title) }}">
                    @error('title')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            {{--
            Handling invalid input fields:

            <input type="text" class="form-control is-invalid" ...>
            <div class="invalid-feedback">
                Message
            </div>
        --}}

            <div class="form-group row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" value="{{ old('description',$post->description) }}">
                    @error('description')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="text" class="col-sm-2 col-form-label">Text*</label>
                <div class="col-sm-10">
                    <textarea rows="5" class="form-control @error('text') is-invalid @enderror" id="text" name="text">{{ old('text',$post->text) }}</textarea>
                    @error('text')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="categories" class="col-sm-2 col-form-label py-0">Categories</label>
                <div class="col-sm-10">
                    {{-- TODO: Read post categories from DB --}}
                    @forelse ($categories as $category)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('categories.*') is-invalid @enderror"
                                value="{{ $category->id }}" id="{{ $category->id }}" name='categories[]'
                                @checked(in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())))>
                            {{-- TODO --}}
                            <label for="{{ $category }}" class="form-check-label">
                                <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                            </label>
                            @if ($loop->last)
                                @error('categories.*')
                                    <div class="invalid-feedback">
                                        <ul>
                                            @foreach ($errors->get('categories.*') as $errormsg)
                                                <li>{{ $errormsg[0] }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @enderror
                            @endif

                        </div>
                    @empty
                        <p>No categories found</p>
                    @endforelse
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Settings</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="form-check">
                            {{-- TODO: Checked --}}
                            <input type="checkbox" class="form-check-input" value="1" id="remove_cover_image"
                                name="remove_cover_image">
                            <label for="remove_cover_image" class="form-check-label">Remove cover image</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-3" id="cover_image_section">
                <label for="cover_image" class="col-sm-2 col-form-label">Cover image</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>
                            <div id="cover_preview" class="col-12">
                                <p>Cover preview:</p>
                                {{-- TODO: Use attached image --}}
                                <img id="cover_preview_image"
                                    @if (isset($post->cover_image_path))
                                        src="{{ '/storage/'.$post->cover_image_path }}"
                                    @else
                                        src="{{ asset('images/default_post_cover.jpg') }}"
                                    @endif
                                    width="300px"
                                    
                                    alt="Cover preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const removeCoverInput = document.querySelector('input#remove_cover_image');
        const coverImageSection = document.querySelector('#cover_image_section');
        const coverImageInput = document.querySelector('input#cover_image');
        const coverPreviewContainer = document.querySelector('#cover_preview');
        const coverPreviewImage = document.querySelector('img#cover_preview_image');
        // Render Blade to JS code:
        // TODO: Use attached image
        const defaultCover = `{{ asset('images/default_post_cover.jpg') }}`;

        removeCoverInput.onchange = event => {
            if (removeCoverInput.checked) {
                coverImageSection.classList.add('d-none');
            } else {
                coverImageSection.classList.remove('d-none');
            }
        }

        coverImageInput.onchange = event => {
            const [file] = coverImageInput.files;
            if (file) {
                coverPreviewImage.src = URL.createObjectURL(file);
            } else {
                coverPreviewImage.src = defaultCover;
            }
        }
    </script>
@endsection
