@extends('layouts.auth-master') 
@section('content')

<form class="form w-100 " method="post" action="{{ route('login.perform') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    @include('layouts.partials.messages')
    <div class="text-center mb-11">
        <img src="{{asset('assets/media/sumbar.png')}}" alt="" class="w-25 mb-3">
        <h1 class="text-gray-900 fw-bolder mb-3">
            Sign In
        </h1>
    </div>
    <div class="fv-row mb-8">
        <label for="email" class="form-label text-gray-500 fw-semibold fs-7">Email atau Username</label>
        <div class="form-group form-floating mb-3">
            <div class="input-group input input-group-solid rounded-4">
                <input
                    id="email"
                    type="text"
                    class="form-control form-control-lg form-control-solid"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Email atau Username"
                    required="required"
                    autofocus
                    autocomplete="off"
                    oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                    oninput="this.setCustomValidity('')"
                />
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
            </div>
            
            @if ($errors->has('username'))
            <span class="text-danger text-left"
                >{{ $errors->first('username') }}</span
            >
            @endif
        </div>
    </div>
    <div class="fv-row mb-8"> 
        <label for="password" class="form-label text-gray-500 fw-semibold fs-7">Password</label>
        <div class="form-group form-floating mb-3">
            <div class="input-group input input-group-solid">
                <input
                    type="password"
                    class="form-control form-control-lg form-control-solid"
                    name="password"
                    id="password"
                    value="{{ old('password') }}"
                    required
                    autocomplete="new-password"
                    oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                    oninput="this.setCustomValidity('')"
                />
                <span class="input-group-text cursor-pointer" onclick="togglePassword()">
                    <i class="fas fa-eye" id="password-eye"></i>
                </span>
            </div>
            @if ($errors->has('password'))
            <span class="text-danger text-left">
                {{ $errors->first('password') }}
            </span>
            @endif
        </div>
    </div>
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary rounded-4 hover-elevate-up">
            <span class="indicator-label">
                Masuk
            </span>
        </button>
    </div>

    @include('auth.partials.copy')
    {{-- <div class="text-gray-500 text-center fw-semibold fs-6">
        Not a Member yet?

        <a href="/metronic8/demo1/authentication/layouts/corporate/sign-up.html" class="link-primary">
            Sign up
        </a>
    </div> --}}
</form>
@endsection

@section('script')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordEye = document.getElementById('password-eye');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordEye.classList.remove('fa-eye');
            passwordEye.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordEye.classList.remove('fa-eye-slash');
            passwordEye.classList.add('fa-eye');
        }
    }
</script>
@endsection