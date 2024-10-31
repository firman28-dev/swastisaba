@extends('partials.index')
@section('heading')
Kabupaten/Kota
@endsection
@section('page')
    Data Kabupaten/Kota
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('zona.update',$zona->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Kabupaten/Kota</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Kabupaten/Kota</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan zona"
                                name="name"
                                required
                                oninvalid="this.setCustomValidity('Kabupaten/Kota tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$zona->name}}"
                            >
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama tidak boleh kosong
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
                <a href="{{route('zona.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#id_level").select2();
    </script>
@endsection
