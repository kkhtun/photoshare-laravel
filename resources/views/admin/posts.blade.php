@extends('layouts.app')

@section('content')
    <div class="row">
        @include('inc.sidebar')
        <div class="col-10">
            <h4>This is admin posts page</h4>
            <div class="mb-2">
                <form action="{{ url()->current() }}" method="GET" id="form-categories">
                    <select name="category" id="select-categories">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}"
                                {{ request()->get('category') && request()->get('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div>
                Count: {{ $posts->total() }}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Caption</td>
                        <td>Author</td>
                        <td>Category</td>
                        <td>Image</td>
                        <td>Likes</td>
                        <td>Comments</td>
                        <td>Created At</td>
                        <td>Updated At</td>
                        <td>Operations</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->caption }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                @foreach ($post->categories as $cat)
                                    <span class="badge badge-secondary">{{ $cat->name }}</span>
                                @endforeach
                            </td>
                            <td><img width="200" src="{{ asset('/images/posts/girl.jpg') }}" alt=""></td>
                            <td>{{ count($post->likes) }}</td>
                            <td>{{ count($post->comments) }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>{{ $post->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post->id) }}"
                                    class="btn btn-outline-info btn-sm">Edit
                                    Post</a>
                                <a href="{{ route('admin.posts.delete', $post->id) }}"
                                    class="btn btn-outline-danger btn-sm">Delete Post</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // For Category Select Filter
        var select = document.getElementById('select-categories');
        select.onchange = function(e) {
            document.getElementById('form-categories').submit();
        }
    </script>
@endsection
