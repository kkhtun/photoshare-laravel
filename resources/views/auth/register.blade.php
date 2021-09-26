@extends('layouts.app')

@section('content')
    <div class="form-wrapper">
        <form class="form" method="POST" action="{{ route($submitRoute) }}">
            @foreach ($errors->all() as $err)
                {{ $err }}
            @endforeach
            @csrf
            <h3>{{ __('Register') }}</h3>
            <div class="form-group">
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Your Username">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" placeholder="Your Email Address">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required
                    autocomplete="new-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Confirm Password">
            </div>

            <div class="form-group">
                <button type="submit">
                    {{ __('Register') }}
                </button>
            </div>
            <p>Already have an account? <a href="{{ route('login') }}">Login Here!</a></p>
        </form>
    </div>
@endsection
