@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($title) }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route($submitRoute) }}">
                            @csrf

                            <input type="hidden" name="id" value="{{ $category->id }}">

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Delete') }}</label>

                                <div class="col-md-6">
                                    <h5>Are you sure you want to delete this category?</h5>
                                    <p class="text-secondary">"{{ $category->name }}"</p>
                                    <span class="text-danger text-sm">Related posts will lose this category tag.</span>
                                    @error('id')
                                        <div>
                                            <strong class="text-danger text-sm">
                                                {{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete Category') }}
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
