@extends('layouts.auth-master') @section('content')
<form method="post" action="{{ route('register.perform') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <img
        class="mb-4"
        src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/1280px-Bootstrap_logo.svg.png"
        alt=""
        width="72"
        height="57"
    />

    <h1 class="h3 mb-3 fw-normal">Register</h1>

    {{-- <div class="form-group form-floating mb-3">
        <input
            type="email"
            class="form-control"
            name="email"
            value="{{ old('email') }}"
            placeholder="name@example.com"
            required="required"
            autofocus
            autocomplete="off"
        />
        <label for="floatingEmail">Email address</label>
        @if ($errors->has('email'))
        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
        @endif
    </div> --}}

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

    @include('auth.partials.copy')
</form>
@endsection