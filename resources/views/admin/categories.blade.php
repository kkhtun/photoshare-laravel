@extends('layouts.app')
@section('content')
    <div class="admin-container">
        @include('inc.sidebar')
        <div class="admin-content">
            <h4>Categories Panel</h4>
            <a href="{{ route('admin.categories.create') }}" class="btn-new"><i class="fas fa-external-link-alt"></i>
                New Category</a>
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
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn-edit-post"><i
                                        class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.categories.delete', $cat->id) }}" class="btn-delete-post"><i
                                        class="fas fa-user-minus"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
