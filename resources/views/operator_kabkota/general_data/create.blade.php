@extends('partials.index')
@section('heading')
    Data Umum
@endsection
@section('page')
    Data Umum
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('g-data.storeKabKota') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Umum</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text"
                                id="provinsi"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Provinsi tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="Sumatera Barat"
                                name="provinsi"
                            >
                            @error('provinsi')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Provinsi tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_zona" class="form-label">Kab/Kota</label>
                            <input type="text"
                                id="id_zona"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Kategory tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$nameZona->name}}"
                            >
                            <input hidden name="id_zona" value="{{$idZona}}">
                            @error('id_zona')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Kategori tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="nama_wako_bup" class="form-label">Nama Walikota/Bupati</label>
                            <input type="text"
                                name="nama_wako_bup"
                                id="nama_wako_bup"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Walikota/Bupati"
                                required
                                oninvalid="this.setCustomValidity('Walikota/Bupati tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('nama_wako_bup')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Walikota/Bupati tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="nama_pembina" class="form-label">Nama Ketua Tim Pembina</label>
                            <input type="text"
                                name="nama_pembina"
                                id="nama_pembina"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Ketua Tim Pembina"
                                required
                                oninvalid="this.setCustomValidity('Nama Ketua Tim Pembina tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('nama_pembina')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama Pembina tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="nama_forum" class="form-label">Nama Forum</label>
                            <input type="text"
                                name="nama_forum"
                                id="nama_forum"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Forum"
                                required
                                oninvalid="this.setCustomValidity('Nama Forum tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('nama_forum')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama Forum tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="nama_ketua_forum" class="form-label">Nama Ketua Forum</label>
                            <input type="text"
                                name="nama_ketua_forum"
                                id="nama_ketua_forum"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Ketua Forum"
                                required
                                oninvalid="this.setCustomValidity('Nama Ketua Forum tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('nama_ketua_forum')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama Ketua Forum tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_category" class="form-label">Alamat Kantor Walikota/Bupati</label>
                            <textarea id="id_category" name="alamat_kantor" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Alamat"></textarea>
                            @error('alamat_kantor')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Alamat kantor tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="alamat_kantor_forum" class="form-label">Alamat Kantor Forum</label>
                            <textarea id="alamat_kantor_forum" name="alamat_kantor_forum" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Alamat Forum"></textarea>
                            @error('alamat_kantor_forum')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Alamat kantor forum tidak boleh kosong
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
                <a href="{{route('g-data.indexKabKota')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#id_category").select2();
        
    </script>
@endsection
