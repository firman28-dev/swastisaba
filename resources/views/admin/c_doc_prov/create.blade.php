@extends('partials.index')
@section('heading')
    Kategori Dokumen Provinsi
@endsection
@section('page')
    Data Kategori Dokumen Provinsi
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('c-doc-prov.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Tatanan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="id_survey" class="form-label">Tahun</label>
                            @php
                                $selected_year = Session::get('selected_year');
                                $date = \App\Models\Trans_Survey::where('id', $selected_year)->first()
                            @endphp
                            <input type="text" id="id_survey"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Tahun"
                                required
                                oninvalid="this.setCustomValidity('Tahun tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$date->trans_date ?? ''}}"
                                readonly
                            >
                            <input name="id_survey" hidden value="{{session('selected_year') ?? ''}}">
                            @error('id_survey')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Kategori  Dokumen Provinsi</label>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Kategori"
                                required
                                oninvalid="this.setCustomValidity('Nama Kategori tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                
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
                        <div class="form-group w-100">
                            <label for="status_activity" class="form-label">Status Kegiatan</label>
                            <select 
                                id="status_activity" 
                                name="status_activity" 
                                aria-label="Default select example"
                                class="form-select form-select-solid rounded rounded-4" 
                                required
                                autocomplete="off"
                                autofocus
                                oninvalid="this.setCustomValidity('Status Kegiatan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                                <option value="">Pilih Status</option>
                                <option value="1">Tidak Aktif</option>
                                <option value="2">Aktif</option>
                            </select>
                            @error('status_activity')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="status_kelembagaan" class="form-label">Status Kelembagaan</label>
                            <select 
                                id="status_kelembagaan" 
                                name="status_kelembagaan" 
                                aria-label="Default select example"
                                class="form-select form-select-solid rounded rounded-4" 
                                required
                                autocomplete="off"
                                autofocus
                                oninvalid="this.setCustomValidity('Status Kelembagaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                                <option value="">Pilih Status</option>
                                <option value="1">Tidak Aktif</option>
                                <option value="2">Aktif</option>
                            </select>
                            @error('status_kelembagaan')
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
                <a href="{{route('c-doc-prov.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#status_activity").select2();
        $("#status_kelembagaan").select2();

    </script>
@endsection
