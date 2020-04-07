@extends('auth/auth_master')

@section('content')
    <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
        @csrf
        <span class="login100-form-logo">
            <img src="https://nganhangphapluat.thukyluat.vn/images/CauHoi_Hinh/9eb6abaa-8cda-456c-ad66-26ba4da23ffe.jpg" width="95px" alt="logo">
        </span>

        <span class="login100-form-title p-b-34 p-t-27">
            Log in
        </span>

        <div class="wrap-input100 validate-input">
            <label class="label-color">Email</label>
            <input class="input100  @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
             @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
   
        <div class="wrap-input100 validate-input">
            <label style="margin-top: 10px" class="label-color">Password</label>
            <input class="input100 @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password">
             @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

       <div class="form-group d-flex justify-content-between">
            <label class="form-check-label label-color">
                <input style="width: 18px; height: 18px;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} checked>
                <span>Keep me signed in </span>
            </label>
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Login
            </button>
        </div>

        <div class="text-center p-t-90">
             @if (Route::has('password.request'))
                <a class="txt1" href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            @endif
        </div>
    </form>
@endsection
