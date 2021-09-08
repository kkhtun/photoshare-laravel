@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($title) }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route($submitRoute) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="caption"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Caption') }}</label>

                                <div class="col-md-6">
                                    <input id="caption" type="text"
                                        class="form-control @error('caption') is-invalid @enderror" name="caption"
                                        value="{{ old('caption') }}" autocomplete="caption" autofocus>

                                    @error('caption')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="categories"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Categories') }}</label>

                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach ($categories as $cat)
                                            <div class="form-check offset-md-1 col-md-5">
                                                <input class="form-check-input" @error('categories') is-invalid @enderror"
                                                    type="checkbox" value="{{ $cat->id }}" id="categories"
                                                    name="categories[]" @if (is_array(old('categories')) && in_array($cat->id, old('categories'))) checked @endif>
                                                <label class="form-check-label" for="categories">
                                                    {{ $cat->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('categories')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                    @if ($errors->has('categories.*'))
                                        @foreach ($errors->get('categories.*') as $err)
                                            <strong class="text-danger">{{ $err[0] }}</strong>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="caption"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" onchange="loadFile(event)">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <img id="output" width="300" class="m-1 rounded-sm">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create Post') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
