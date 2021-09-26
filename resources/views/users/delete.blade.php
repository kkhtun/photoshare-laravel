@extends('layouts.app')

@section('content')


    <div class="card-wrapper">
        <div class="profile-card">
            <h4>{{ __($title) }}</h4>
            <hr>
            <div class="profile-card-body">
                <form method="POST" action="{{ route($submitRoute) }}" class="user-delete-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="form-group">
                        <h4>The following account will be deleted from the database.</h4>
                        <p><i class="fas fa-exclamation-triangle"></i></p>
                        <p id="name">{{ $user->name }}</p>
                        <p class="email">{{ $user->email }}</p>
                        <span class="delete-data-notice">All related posts and data will be
                            deleted.</span>
                    </div>

                    {{-- If user is not admin, ie self-deleting account, then check his/her pw --}}
                    @if (Auth::guard('web')->check())
                        {{-- <div class="
                            form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Please type your password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <input id="password" type="password"
                                class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                placeholder="{{ __('Please type your password') }}" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="form-group">
                        <button type="submit" class="btn-delete-post">
                            {{ __('Delete User') }}
                        </button>
                        <button type="button" class="btn-edit-post" onclick="history.back();">
                            {{ __('Back') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
