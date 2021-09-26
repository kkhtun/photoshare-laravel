@extends('layouts.app')

@section('content')
    <div class="form-wrapper">
        <form class="form" method="POST" action="{{ route($passwordUpdateRoute) }}">
            @csrf
            <h3>{{ $title }}</h3>
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    value="{{ $email ?? old('email') }}" required autofocus placeholder="Confirm Your Email">

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" required placeholder="New Password">

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" name="password_confirmation" required
                    placeholder="Confirm Your New Password">
            </div>

            <div class="form-group">
                <button type="submit">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
