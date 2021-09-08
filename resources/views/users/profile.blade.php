@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}" width="50"
                            class="rounded-circle mb-2">
                        <h5>{{ $user->name }}</h5>
                        <p>Email: {{ $user->email }}</p>
                        <p>Posts: {{ count($user->posts) }}</p>
                        <div>
                            <a href="{{ route('users.edit') }}">Change Details</a>
                            {{-- <a href="">Delete Account</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
