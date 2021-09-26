@extends('layouts.app')

@section('content')

    <div class="filters">
        <form action="{{ url()->current() }}" method="GET" id="category-filter" onchange="this.submit();">
            <select name="category">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request()->category == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}</option>
                @endforeach
            </select>

            @isset($users)
                <select name="user" id="author-select">
                    <option value="">All Authors</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->slug }}" {{ request()->user == $user->slug ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            @endisset
        </form>
    </div>

    <div class="card-wrapper">
        @foreach ($posts as $post)
            <div class="card">
                <div class="card-banner">
                    <img class="banner-img" src="{{ url('/images/posts/girl.jpg') }}" alt="" />
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
                        <span class="btn-like likes" data-postid="{{ $post->id }}"
                            data-userid="{{ auth()->check() ? auth()->user()->id : 0 }}"><i
                                class="far fa-thumbs-up like-icon {{ $post->likes }}"></i><strong>{{ count($post->likes) }}</strong></span>
                        <span class="comments"
                            onclick="document.location = '{{ url('/detail/' . $post->slug) }}#comment-form';"><i
                                class="far fa-comment comment-icon"></i><strong>{{ count($post->comments) }}</strong></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination" style="display:flex; justify-content: center;">
        {!! $posts->links() !!}
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var likeButtons = document.querySelectorAll('.btn-like');
        likeButtons.forEach(likeBtn => addLikeEvent(likeBtn, "{{ auth()->check() ? auth()->user()->api_token : 0 }}"));
    </script>
@endsection
