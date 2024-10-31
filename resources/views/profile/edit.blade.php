@extends('partials.index')
@section('heading')
    Profile
@endsection
@section('page')
    Data Profile
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('user.updateProfile') }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    @if (!is_null($userFind->id_zona))
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label for="id_group" class="form-label">Kabupaten/Kota</label>
                                <input type="text" class="form-control form-control-solid rounded rounded-4" value="{{$userFind->_zona->name}}" readonly>
                                <input hidden name="id_zona" value="{{$userFind->id_zona}}">
                                @error('id_zona')
                                    <div class="is-invalid">
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_group" class="form-label">Nama</label>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama"
                                required
                                autofocus
                                autocomplete="off"
                                oninvalid="this.setCustomValidity('Nama tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$userFind->name}}"
                            >
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_group" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Email"
                                required
                                autofocus
                                autocomplete="off"
                                oninvalid="this.setCustomValidity('Email tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$userFind->email}}"
                            >
                            @error('email')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_group" class="form-label">Username</label>
                            <input type="text" id="email" name="username"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Username"
                                required
                                autofocus
                                autocomplete="off"
                                oninvalid="this.setCustomValidity('Username tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$userFind->username}}"
                            >
                            @error('username')
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
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('user.profile')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection
@section('script')
   
@endsection
