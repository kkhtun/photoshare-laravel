@extends('layouts.app')

@section('content')
    <div class="container">
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
                                    <button>Delete</button>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var api_token = "{{ $user !== null ? $user->api_token : 0 }}";
        var likeButton = document.querySelector('.btn-like');
        addLikeEvent(likeButton, api_token);

        var cmtForm = document.getElementById('comment-form');
        addCommentSubmitEvent(cmtForm, api_token)
    </script>
@endsection
