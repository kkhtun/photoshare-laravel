@extends('layouts.app')

@section('content')
    <div class="form-wrapper">
        <form class="form" method="POST" action="{{ route($passwordEmailRoute) }}">
            @csrf
            <h3>{{ $title }}</h3>
            <div class="form-group">
                <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    value="{{ old('email') }}" required placeholder="example@gmail.com">

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
@endsection
