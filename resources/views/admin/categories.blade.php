@extends('layouts.app')
@section('content')
    <div class="row">
        @include('inc.sidebar')
        <div class="col-10">
            <h4>This is admin categories page</h4>
            <a href="{{ route('admin.categories.create') }}">Create New Category</a>
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Posts</td>
                        <td>Created At</td>
                        <td>Updated At</td>
                        <td>Operations</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ count($cat->posts) }}</td>
                            <td>{{ $cat->created_at }}</td>
                            <td>{{ $cat->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                    class="btn btn-outline-info btn-sm">Edit
                                    Post</a>
                                <a href="{{ route('admin.categories.delete', $cat->id) }}"
                                    class="btn btn-outline-danger btn-sm">Delete Post</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
