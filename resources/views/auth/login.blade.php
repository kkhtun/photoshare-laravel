@extends('layouts.app')
@section('content')
    <div class="form-wrapper">
        <form class="form" method="POST" action="{{ route($loginRoute) }}">
            @csrf
            <h3>{{ $title }}</h3>
            <div class="form-group">
                <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    value="{{ old('email') }}" placeholder="Your Email Here" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" placeholder="Your Password Here" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group check">
                <label for="remember">
                    {{ __('Remember Me') }}
                </label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            </div>
            @if (Route::has('password.request'))
                <p>Forgot your password? <a href="{{ route($forgotPasswordRoute) }}">Click Here</a></p>
            @endif
            <div class="form-group">
                <button type="submit">
                    {{ __('Login') }}
                </button>
            </div>
            <p>Don't have an account? <a href="{{ route('register') }}">Register Now!</a></p>
        </form>
    </div>
@endsection
