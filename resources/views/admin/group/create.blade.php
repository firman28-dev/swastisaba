@extends('partials.index')
@section('heading')
    Role Akses
@endsection
@section('page')
    Data Role Akses
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('group.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Level</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Nama Role Akses</label>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Role Akses"
                                required
                                oninvalid="this.setCustomValidity('Nama Role Akses tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                
                            >
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama Role Akses tidak boleh kosong
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

