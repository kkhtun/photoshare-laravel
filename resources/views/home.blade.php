@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">{{ __($title) }}</div>

                    <div class="card-body">
                        <div>
                            Count: {{ $posts->total() }}
                        </div>
                        <div class="border border-secondary mb-2">
                            <a href="{{ url()->current() }}">All</a> |
                            @foreach ($categories as $cat)
                                <a href="{{ url()->current() . '?category=' . $cat->slug }}">{{ $cat->name }}</a> |
                            @endforeach
                        </div>
                        @auth
                            <div class="border border-secondary mb-2">
                                <a href="{{ route('home') }}">All</a> |
                                @foreach (\App\User::all() as $user)
                                    <a href="{{ "/users/posts/$user->slug" }}">{{ $user->name }}</a> |
                                @endforeach
                            </div>
                        @endauth
                        <section class="row px-2">
                            @foreach ($posts as $post)
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">{{ $post->caption }}</div>
                                        <div class="card-body">
                                            <img class="card-img" src="{{ url('/images/posts/girl.jpg') }}"
                                                alt="post image">
                                            <p class="text-muted">{{ $post->user->name }}</p>
                                            <div>
                                                <button class="btn btn-like btn-sm btn-outline-primary"
                                                    data-postid="{{ $post->id }}"
                                                    data-userid="{{ auth()->check() ? auth()->user()->id : 0 }}">Like :
                                                    <span>{{ count($post->likes) }}</span>
                                                </button>
                                                <span>Comments: {{ count($post->comments) }}</span>
                                            </div>
                                            <a href="{{ url('/detail/' . $post->slug) }}"
                                                class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ url('/posts/edit/' . $post->slug) }}"
                                                class="btn btn-secondary btn-sm">Edit</a>
                                            <a href="{{ url('/posts/delete/' . $post->slug) }}"
                                                class="btn btn-warning btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </section>
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var likeButtons = document.querySelectorAll('.btn-like');
        likeButtons.forEach(likeBtn => addLikeEvent(likeBtn, "{{ auth()->check() ? auth()->user()->api_token : 0 }}"));
    </script>
@endsection
