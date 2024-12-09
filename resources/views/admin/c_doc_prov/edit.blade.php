@extends('partials.index')
@section('heading')
    Kategori Dokumen Provinsi
@endsection
@section('page')
    Data Kategori Dokumen Provinsi
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('c-doc-prov.update',$category->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Kategori</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Nama kategori tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{ $category->name }}"
                                
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
                                <option value="1" {{ $category->status_activity === '1' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="2" {{ $category->status_activity === '2' ? 'selected' : '' }}>Aktif</option>
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
                                <option value="1" {{ $category->status_kelembagaan === '1' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="2" {{ $category->status_kelembagaan === '2' ? 'selected' : '' }}>Aktif</option>
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


