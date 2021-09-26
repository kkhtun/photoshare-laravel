@extends('layouts.app')

@section('content')
    <div class="form-wrapper">
        <form method="POST" action="{{ route($submitRoute) }}" enctype="multipart/form-data" class="post-form">
            @csrf
            <input type="hidden" name="id" value="{{ $post->id }}">
            <div class="img-preview">
                <img src="{{ asset('images/posts/' . $post->filename) }}" id="output" />
            </div>
            <div class="post-input">
                <h3>{{ __($title) }}</h3>
                <div class="form-group">
                    <input id="caption" type="text" placeholder="Post Caption" class="@error('caption') is-invalid @enderror"
                        name="caption" value="{{ old('caption') ? old('caption') : $post->caption }}"
                        autocomplete="caption" autofocus>

                    @error('caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group form-categories">
                    @foreach ($categories as $cat)
                        <span><input type="checkbox" class="@error('categories') is-invalid @enderror"
                                value="{{ $cat->id }}" id="categories" name="categories[]" @if (is_array(old('categories')))
                            {{ in_array($cat->id, old('categories')) ? 'checked' : '' }}
                        @else
                            {{ in_array($cat->id, $post->categoryIds) ? 'checked' : '' }}
                    @endif/>
                    {{ $cat->name }}</span>
                    @endforeach
                </div>
                <div class="text-center">
                    @error('categories')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    @if ($errors->has('categories.*'))
                        @foreach ($errors->get('categories.*') as $err)
                            <strong class="text-danger">{{ $err[0] }}</strong>
                        @endforeach
                    @endif
                </div>
                <div class="form-group form-image">
                    <label for="image"><i class="far fa-file-image"></i>&nbsp;Upload Image</label>
                    <input id="image" type="file" class="@error('image') is-invalid @enderror" name="image"
                        onchange="loadFile(event)" />
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit">{{ __('Update Post') }}</button>
                    <button type="button" onclick="history.back();">Back</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        // This is to preview before upload
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
