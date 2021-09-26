@extends('layouts.app')
@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($title) }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route($submitRoute) }}">
                            @csrf
                            @if (isset($category))
                                <input type="hidden" name="id" value="{{ $category->id }}">
                            @endif
                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                                <div class="col-md-6">
                                    @if (isset($category))
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') ? old('name') : $category->name }}" required
                                            autocomplete="name" autofocus>
                                    @else
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @endif

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @error('id')
                                        <div>
                                            <strong class="text-sm text-danger">
                                                {{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create Category') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="form-wrapper">
        <form method="POST" action="{{ route($submitRoute) }}" enctype="multipart/form-data"
            class="post-form category-form">
            @csrf
            <div class="post-input">
                <h3>{{ __($title) }}</h3>
                <div class="form-group">
                    @if (isset($category))
                        <input type="hidden" name="id" value="{{ $category->id }}">
                    @endif
                    @if (isset($category))
                        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') ? old('name') : $category->name }}" required autocomplete="name"
                            autofocus placeholder="Change Category">
                    @else
                        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="New Category">
                    @endif

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('id')
                        <div class="text-center">
                            <strong class="text-danger">
                                {{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit">{{ __($title) }}</button>
                    <button type="button" onclick="history.back();">Back</button>
                </div>
            </div>
        </form>
    </div>
@endsection
