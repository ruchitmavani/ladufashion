@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <input id="email" type="email" class="input-fixed @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                            <label for="email" class="label-name">
                                <span class="content-name">Email</span>
                            </label>
                        </div>
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                         
                        <div class="form-group">                                       
                            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                            <label for="password" class="label-name">
                                <span class="content-name">Password</span>
                            </label>
                        </div>
                        @error('password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group">
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                            <label for="password-confirm" class="label-name">
                                <span class="content-name">Confirm Password</span>
                            </label>
                        </div>

                        <div class="row mb-0 mt-3">
                            <div class="col-md-6 mx-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
