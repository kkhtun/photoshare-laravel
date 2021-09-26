@extends('layouts.app')

@section('content')
    <div class="card-wrapper">
        <div class="profile-card">
            <h4>{{ __('Profile') }}</h4>
            <hr>
            <div class="profile-card-body">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=ADD8E6" class="profile-avatar">
                <h5>{{ $user->name }}</h5>
                <p class="email">{{ $user->email }}</p>
                <p class="post-count"><span>{{ count($user->posts) }}</span> posts in total</p>
                <div class="profile-edit">
                    <a href="{{ route('users.edit') }}" class="btn-edit-post">Change Details</a>
                </div>
            </div>
        </div>
    </div>
@endsection
