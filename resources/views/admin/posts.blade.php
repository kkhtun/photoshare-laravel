@extends('layouts.app')

@section('content')
    <div class="admin-container">
        @include('inc.sidebar')
        <div class="admin-content">
            <h4>Posts Panel</h4>
            <div class="admin-filters">
                <form action="{{ url()->current() }}" method="GET" id="category-filter" onchange="this.submit();">
                    <select name="category">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request()->category == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <select name="user" id="author-select">
                        <option value="">All Authors</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->slug }}" {{ request()->user == $user->slug ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div>
                This page: {{ $posts->total() }}
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
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn-edit-post"><i
                                        class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.posts.delete', $post->id) }}" class="btn-delete-post"><i
                                        class="fas fa-user-minus"></i></a>
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
