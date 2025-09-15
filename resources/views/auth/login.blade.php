@extends('layouts.auth-master') 
@section('content')

<p class="subtitle is-4 pb-5 has-text-weight-bold has-text-white">Silahkan Login</p>
<form method="post" action="{{ route('login.perform') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="field">
        <div class="control has-icons-left has-icons-right">
            <input 
                class="input is-medium" 
                type="text" 
                placeholder="Username atau Email" 
                name="username"
                value="{{ old('username') }}"
                autofocus
                required
                autocomplete="off"
                oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                oninput="this.setCustomValidity('')"
            />
            <span class="icon is-medium is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <div class="control has-icons-left has-icons-right">
            <input 
                class="input is-medium" 
                type="password" 
                placeholder="Password" 
                id="password"
                name="password"
                value="{{ old('password') }}"
                required
                autocomplete="new-password"
                oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                oninput="this.setCustomValidity('')"
            />
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
            <span class="icon is-small is-right" style="pointer-events: all; cursor: pointer"  onclick="togglePassword()">
                <i id="toggle-icon" class="fas fa-eye-slash"></i>
            </span>
        </div>
    </div>

    {{-- <span class="has-text-weight-bold has-text-white" >Belum Punya Akun? <a href="{{ route('register.show') }}">Daftar</a></span> --}}
    <div class="column is-flex is-half is-offset-one-quarter">
        <button class="button is-block is-info is-medium is-fullwidth has-text-weight-normal has-text-dark">
        Login
        </button>
    </div>
</form>

@endsection

@section('script')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordEye = document.getElementById('password-eye');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordEye.classList.remove('fa-eye-slash');
            passwordEye.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            passwordEye.classList.remove('fa-eye');
            passwordEye.classList.add('fa-eye-slash');
        }
    }
</script>
@endsection