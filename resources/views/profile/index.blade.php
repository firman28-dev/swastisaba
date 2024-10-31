@extends('partials.index')
@section('heading')
    Profile
@endsection
@section('page')
    Data Profile
@endsection


@section('content')
<div class="row">
    {{-- <div class="card mb-5">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Foto</h3>
            </div>
            <a href="{{route('user.editPhoto')}}" class="btn btn-primary btn-sm align-self-center hover-scale">Edit Foto</a>
        </div>
        <div class="card-body">
            @if ($userFind->photo)
                <img src="{{ asset('uploads/photo/' . $userFind->photo) }}" alt="Foto Pengguna" class="img-fluid rounded" style="max-width: 200px">
            @else
                <p>Belum ada foto</p>
            @endif
        </div>
    </div> --}}

    <div class="card mb-5" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile</h3>
            </div>
            <a href="{{route('user.editProfile')}}" class="btn btn-primary btn-sm align-self-center hover-scale">Edit Profile</a>
        </div>
        <div class="card-body p-9">
            <div class="row">
                <div class="col-lg-4 mb-lg-0 mb-3">
                    <div class="d-flex flex-column">
                        @if ($userFind->photo)
                        <img src="{{ asset('uploads/photo/' . $userFind->photo) }}" alt="Foto Pengguna" class="img-fluid rounded mb-2 text-center" style="max-width: 250px">
                        @else
                            <img src="{{ asset('assets/media/blank.png') }}" alt="default user" class="mb-2 text-center" style="max-width: 250px"/>
                            {{-- <p>Belum ada foto</p> --}}
                        @endif
                        <div class="d-flex flex-row gap-2">
                            <a href="{{route('user.editPhoto')}}" class="btn btn-primary btn-sm align-self-center hover-scale">Edit Foto</a>
                            <form action="{{ route('user.resetPhoto') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm align-self-center hover-scale">Hapus Foto</button>
                            </form>
                            {{-- <a href="{{route('user.resetPhoto')}}" class="btn btn-danger btn-sm align-self-center hover-scale">Hapus Foto</a> --}}
                        </div>

                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row mb-7">
                        <label class="col-lg-3 fw-semibold text-muted">Role Akses</label>
                        <div class="col-lg-9 fv-row">
                            <span class="fw-bold fs-6 text-gray-800">{{$userFind->_group->name ?? 'Belum ada'}}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-3 fw-semibold text-muted">Nama</label>
                        <div class="col-lg-9 fv-row">
                            <span class="fw-bold fs-6 text-gray-800">{{$userFind->name ?? 'Belum ada'}}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-3 fw-semibold text-muted">Email</label>
                        <div class="col-lg-9 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">{{$userFind->email ?? 'Belum ada'}}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-3 fw-semibold text-muted">Username</label>
                        <div class="col-lg-9 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">{{$userFind->username ?? 'Belum ada'}}</span>
                        </div>
                    </div>
                    @if (!is_null($userFind->id_zona))
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Nama Kabupaten Kota</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-bold fs-6 text-gray-800">{{$userFind->_zona->name}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="card">
        <form action="{{route('user.updatePassword')}}" method="POST">
            @csrf
            @method('put')
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Password</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="new-password-input" class="form-label">Password Baru</label>
                            <div class="input-group mb-5">
                                <input type="password" name="new_password"
                                    class="form-control"
                                    placeholder="Masukkan Confirm Password"
                                    required
                                    autofocus
                                    autocomplete="off"
                                    oninvalid="this.setCustomValidity('Password tidak boleh kosong.')"
                                    oninput="this.setCustomValidity('')"
                                    id="new-password-input"
                                >
                                <span class="input-group-text" onclick="togglePassword('new-password')">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </span>
                            </div>
                            @error('new_password')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="confirm-password-input" class="form-label">Confirm Password</label>
                            <div class="input-group mb-5">
                                <input type="password" name="confirm_password"
                                    class="form-control"
                                    placeholder="Masukkan Confirm Password"
                                    required
                                    autofocus
                                    autocomplete="off"
                                    oninvalid="this.setCustomValidity('Password tidak boleh kosong.')"
                                    oninput="this.setCustomValidity('')"
                                    id="confirm-password-input"
                                >
                                <span class="input-group-text" onclick="togglePassword('confirm-password')">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </span>
                            </div>
                            
                            
                            @error('confirm_password')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary btn-outline btn-sm hover-scale">Simpan</button>
            </div>
        </form>
        
    </div>
</div>

@endsection

@section('script')
    <script>
        function togglePassword(id) {
            var input = document.getElementById(id + '-input');
            var eye = document.getElementById(id + '-eye');
            if (input.type === "password") {
                input.type = "text";
                eye.className = "fas fa-eye-slash";
            } else {
                input.type = "password";
                eye.className = "fas fa-eye";
            }
        }
    </script>
@endsection
