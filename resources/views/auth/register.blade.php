@extends('layouts.auth-master') 
@section('content')
{{-- <form method="post" action="{{ route('register.perform') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <img
        class="mb-4"
        src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/1280px-Bootstrap_logo.svg.png"
        alt=""
        width="72"
        height="57"
    />

    <h1 class="h3 mb-3 fw-normal">Register</h1>

    <div class="form-group form-floating mb-3">
        <select
        class="form-control"
        name="id_group"
        required="required"
        autocomplete="off"
        autofocus
        >
            <option value="" disabled selected>Pilih Role Akses</option>
            @foreach($group as $data)
                <option value="{{ $data->id }}" {{ old('id_group') == $data->id ? 'selected' : '' }}>
                    {{ $data->name }}
                </option>
            @endforeach
        </select>
        <label for="floatingRole">Role Akses</label>
        @if ($errors->has('id_group'))
        <span class="text-danger text-left">
            {{ $errors->first('id_group') }}
        </span>
        @endif
    </div>

    <div class="form-group form-floating mb-3">
        <select
        class="form-control"
        name="id_zona"
        required="required"
        autocomplete="off"
        autofocus
        >
            <option value="" disabled selected>Pilih Zona Akses</option>
            @foreach($zona as $data)
                <option value="{{ $data->id }}" {{ old('id_group') == $data->id ? 'selected' : '' }}>
                    {{ $data->name }}
                </option>
            @endforeach
        </select>
        <label for="floatingRole">Role Akses</label>
        @if ($errors->has('id_group'))
        <span class="text-danger text-left">
            {{ $errors->first('id_group') }}
        </span>
        @endif
    </div>

    <div class="form-group form-floating mb-3">
        <input
            type="text"
            class="form-control"
            name="username"
            value="{{ old('username') }}"
            placeholder="Username"
            required="required"
            autofocus
            autocomplete="off"
        />
        <label for="floatingName">Username</label>
        @if ($errors->has('username'))
        <span class="text-danger text-left"
            >{{ $errors->first('username') }}</span
        >
        @endif
    </div>

    <div class="form-group form-floating mb-3">
        <input
            type="password"
            class="form-control"
            name="password"
            value="{{ old('password') }}"
            placeholder="Password"
            required="required"
            autocomplete="new-password"
        />
        <label for="floatingPassword">Password</label>
        @if ($errors->has('password'))
        <span class="text-danger text-left"
            >{{ $errors->first('password') }}</span
        >
        @endif
    </div>

    <div class="form-group form-floating mb-3">
        <input
            type="password"
            class="form-control"
            name="password_confirmation"
            value="{{ old('password_confirmation') }}"
            placeholder="Confirm Password"
            required="required"
            autocomplete="new-password"

        />
        <label for="floatingConfirmPassword">Confirm Password</label>
        @if ($errors->has('password_confirmation'))
        <span class="text-danger text-left"
            >{{ $errors->first('password_confirmation') }}</span
        >
        @endif
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>

</form> --}}
    {{-- @include('auth.partials.copy') --}}


    <p class="subtitle is-4 pb-5 has-text-weight-bold has-text-white">Silahkan Register</p>
    <form method="post" action="{{ route('register.perform') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="field">
            <div class="control has-icons-left has-icons-right">
                <input 
                    class="input is-medium" 
                    type="text" 
                    placeholder="Username" 
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
                    type="email" 
                    placeholder="Email" 
                    name="email"
                    value="{{ old('email') }}"
                    autofocus
                    required
                    autocomplete="off"
                    {{-- oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                    oninput="this.setCustomValidity('')" --}}
                />
                <span class="icon is-medium is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <div class="control has-icons-left">
                <div class="select is-medium is-fullwidth">
                    <select name="id_zona" required>
                        <option value="" disabled selected>Pilih Kab/Kota</option>
                        @foreach($zona as $z)
                            <option value="{{ $z->id }}">{{ $z->name }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="icon is-small is-left">
                    <i class="fas fa-map-marker-alt"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <div class="control has-icons-left">
                <div class="select is-medium is-fullwidth">
                    <select name="id_group" required>
                        <option value="" disabled selected>Pilih Role</option>
                        @foreach($group as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="icon is-small is-left">
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
        <span class="has-text-weight-bold has-text-white">Sudah Punya Akun? <a href="{{ route('login.show') }}">Login</a></span>
        <div class="column is-flex is-half is-offset-one-quarter">
            <button class="button is-block is-info is-medium is-fullwidth has-text-weight-normal has-text-dark">
            Register
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