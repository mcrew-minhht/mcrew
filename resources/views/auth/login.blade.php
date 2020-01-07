@extends('auth/auth_master')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="label">Email</label>
            <div class="input-group">
                <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label style="margin-top: 10px" class="label">Password</label>
            <div class="input-group">
                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button style="margin-top: 10px" type="submit" class="btn btn-primary submit-btn btn-block">Login</button>
        </div>
        <div class="form-group d-flex justify-content-between">
            <div class="form-check form-check-flat mt-0">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} checked>Keep me signed in </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-small forgot-password text-black">Forgot Password</a>
            @endif

        </div>
        <div class="form-group">



        </div>
    </form>
@endsection
