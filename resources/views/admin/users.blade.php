@extends('layouts.app')

@section('content')
    <div class="admin-container">
        @include('inc.sidebar')
        <div class="admin-content">
            <h4>Users Panel</h4>
            <a href="{{ route('admin.users.register') }}" class="btn-new">Register <i
                    class="fas fa-user-plus"></i></a>
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Posts</td>
                        <td>Created At</td>
                        <td>Updated At</td>
                        <td>Last Login</td>
                        <td>Operations</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ count($user->posts) }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>{{ $user->last_login }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit-post"><i
                                        class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.users.delete', $user->id) }}" class="btn-delete-post"><i
                                        class="fas fa-user-minus"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection
