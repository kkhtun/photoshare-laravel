@extends('layouts.app')

@section('content')
    <div class="form-wrapper">
        <form class="form" method="POST" action="{{ route($submitRoute) }}">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <h3>{{ __($title) }}</h3>
            <div class="form-group">
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                    placeholder="Change Username" value="{{ old('name') ? old('name') : $user->name }}" required
                    autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') ? old('email') : $user->email }}" required autocomplete="email"
                    placeholder="Change Email Address">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <span><i class="fas fa-exclamation-circle"></i>&nbsp;Leave the following fields blank if you do not wish to
                    change
                    password
                </span>
            </div>
            <div class="form-group">
                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
                    autocomplete="new-password" placeholder="Enter New Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password"
                    placeholder="Confirm New Password">
            </div>

            <div class="form-group">
                <button type="submit">
                    {{ __('Update User') }}
                </button>
            </div>
            <p>Not Now? <a href="#" onclick="history.back();">Back</a></p>
        </form>
    </div>
@endsection
