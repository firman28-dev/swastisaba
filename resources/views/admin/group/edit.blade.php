@extends('partials.index')
@section('heading')
    Role User
@endsection
@section('page')
    Data Role User
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('group.update',$group->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Role User</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Nama Role User</label>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan role user"
                                required
                                oninvalid="this.setCustomValidity('Role user tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{ $group->name }}"
                                
                            >
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Role user tidak boleh kosong
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
                <a href="{{route('group.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

