@extends('layouts.app')

@section('content')
    <div class="row">
        @include('inc.sidebar')
        <div class="col-10">
            <h4>This is admin users page</h4>
            <a href="{{ route('admin.users.register') }}">Register New User</a>
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
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="btn btn-outline-info btn-sm">Edit
                                    Details</a>
                                <a href="{{ route('admin.users.delete', $user->id) }}"
                                    class="btn btn-outline-danger btn-sm">Delete User</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection
