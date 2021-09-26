@extends('layouts.app')
@section('content')
    {{-- The following view uses the same styles as user delete view, check css --}}
    <div class="card-wrapper">
        <div class="profile-card">
            <h4>{{ __($title) }}</h4>
            <hr>
            <div class="profile-card-body">
                <form method="POST" action="{{ route($submitRoute) }}" class="user-delete-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $category->id }}">

                    <div class="form-group">
                        <h4>The following category will be deleted from the database.</h4>
                        <p><i class="fas fa-exclamation-triangle"></i></p>
                        <p id="name">{{ $category->name }}</p>
                        <span class="delete-data-notice">Related posts will lose this category tag.</span>
                    </div>

                    @error('id')
                        <div class="text-center">
                            <strong class="text-danger">
                                {{ $message }}</strong>
                        </div>
                    @enderror

                    <div class="form-group">
                        <button type="submit" class="btn-delete-post">
                            {{ __('Delete Category') }}
                        </button>
                        <button type="button" class="btn-edit-post" onclick="history.back();">
                            {{ __('Back') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
