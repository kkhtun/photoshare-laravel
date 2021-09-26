@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $post->caption }}</div>

                    <div class="card-body">
                        <p>Author: {{ $post->user->name }}</p>
                        <div>
                            @foreach ($post->categories as $cat)
                                <span class="badge badge-secondary">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                        <img src="{{ url('/images/posts/' . $post->filename) }}" alt="" width="400">
                        <hr>
                        <div>
                            <button class="btn btn-like btn-sm btn-outline-primary" data-postid="{{ $post->id }}"
                                data-userid="{{ $user !== null ? $user->id : 0 }}">Like :
                                <span>{{ count($post->likes) }}</span>
                            </button>
                        </div>
                        <a href="{{ url('/detail/' . $post->slug) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ url('/posts/edit/' . $post->slug) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <a href="{{ url('/posts/delete/' . $post->slug) }}" class="btn btn-warning btn-sm">Delete</a>
                        <hr>


                        <form id="comment-form" class="text-center" method="" action="#"
                            data-postid="{{ $post->id }}" data-userid="{{ $user !== null ? $user->id : 0 }}">
                            <input type="text" name="comment" class="w-75" id="comment-input"
                                placeholder="Comment...">
                            <button type="submit" name="submit-comment" class="btn btn-secondary">Comment</button>
                        </form>
                        <div class="mt-2" id="comment-list">
                            @foreach ($post->comments as $comment)
                                <div class="comment-item border border-secondary rounded p-2 mb-1">
                                    <p>{{ $comment->comment }}</p>
                                    <small>{{ $comment->user->name }}</small><span>
                                        {{ $comment->created_at->diffForHumans() }}</span>
                                    <button data-userid="{{ $user !== null ? $user->id : 0 }}"
                                        data-commentid="{{ $comment->id }}" class="btn-comment-delete">Delete</button>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="caption-wrapper">
        <h2>{{ $post->caption }}</h2>
    </div>
    <div class="post-wrapper">
        <img src="https://images.unsplash.com/photo-1515879218367-8466d910aaa4?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
            alt="" />
        <hr />
        <div class="post-interact">
            <span class="text">Don't forget to like and comment and drop your thoughts!</span>
            <span class="likes btn-like" data-postid="{{ $post->id }}"
                data-userid="{{ $user !== null ? $user->id : 0 }}"><i
                    class="far fa-thumbs-up like-icon"></i><strong>{{ count($post->likes) }}</strong></span>
            <span class="comments"
                onclick="document.getElementById('comment-list').scrollIntoView();document.getElementById('comment-input').focus();"><i
                    class="far fa-comment comment-icon"></i><strong>{{ count($post->comments) }}</strong></span>
        </div>
        <hr />
        <p class="categories">
            @foreach ($post->categories as $cat)
                <span>{{ $cat->name }}</span>
            @endforeach
        </p>
        <p class="author">Authored By <span>{{ $post->user->name }}</span></p>
        @if ($user !== null && $post->user_id === $user->id)
            <div>
                <a href="{{ url('/posts/edit/' . $post->slug) }}" class="btn-edit-post">Edit</a>
                <a href="{{ url('/posts/delete/' . $post->slug) }}" class="btn-delete-post">Delete</a>
            </div>
        @endif
        <section class="comment-section">
            <form method="" action="#" class="comment-form" id="comment-form" data-postid="{{ $post->id }}"
                data-userid="{{ $user !== null ? $user->id : 0 }}">
                <input type="text" name="comment" placeholder="Comment" id="comment-input" />
                <button type="submit" name="submit-comment" class="btn-comment">Comment</button>
            </form>
            <div class="comment-list" id="comment-list">
                @foreach ($post->comments as $comment)
                    <div class="comment-card">
                        <p>{{ $comment->comment }}</p>
                        <span>By <strong>{{ $comment->user->name }}</strong>
                            <i>{{ $comment->created_at->diffForHumans() }}</i></span>
                        <button data-userid="{{ $user !== null ? $user->id : 0 }}" data-commentid="{{ $comment->id }}"
                            class="comment-delete">Delete</button>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var api_token = "{{ $user !== null ? $user->api_token : 0 }}";
        var likeButton = document.querySelector('.btn-like');
        addLikeEvent(likeButton, api_token);

        var cmtForm = document.getElementById('comment-form');
        addCommentSubmitEvent(cmtForm, api_token);

        var cmtDeleteBtns = document.querySelectorAll('.comment-delete');
        cmtDeleteBtns.forEach(deleteBtn => addDeleteCommentEvent(deleteBtn,
            api_token));
    </script>
@endsection
