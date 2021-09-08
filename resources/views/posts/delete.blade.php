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
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <div class="form-group row">
                                <label for="caption"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Caption') }}</label>

                                <div class="col-md-6">
                                    <h5>{{ $post->caption }}</h5>
                                    @error('id')
                                        <strong class="text-danger">Something wrong, please try again</strong>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                                <div class="col-md-6">
                                    <img id="image" width="300" class="m-1 rounded-sm"
                                        src="{{ asset('images/posts/' . $post->filename) }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete Post') }}
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
