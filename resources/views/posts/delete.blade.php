@extends('layouts.app')

@section('content')

    <div class="card-wrapper">
        <div class="card">
            <div class="card-banner">
                <img class="banner-img" src="{{ asset('images/posts/' . $post->filename) }}" alt="" />
            </div>
            <div class="card-body">
                <p class="categories">
                    @foreach ($post->categories as $cat)
                        <span>{{ $cat->name }}</span>
                    @endforeach
                </p>
                <h2 class="post-caption">{{ $post->caption }}</h2>
                <p class="post-author"><small>By {{ $post->user->name }}</small></p>
                <div class="post-interact">
                    <span><a href="{{ url('/detail/' . $post->slug) }}">View Post</a></span>
                </div>
            </div>
        </div>
        <div class="form-wrapper">
            <form class="post-form" method="POST" action="{{ route($submitRoute) }}" enctype="multipart/form-data">
                <div class="post-input m-auto post-delete">
                    @csrf
                    <div class="form-group">
                        <h4>{{ __($title) }}<i class=" far fa-calendar-times"></i></h4>
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <small>You cannot reverse this action!</small>
                    </div>
                    <div class="form-group">
                        <button type="submit">{{ __('Delete Post') }}</button>
                        <button type="button" onclick="history.back();">Back</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
