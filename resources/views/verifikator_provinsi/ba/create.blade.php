@extends('partials.index')
@section('heading')
    Berita Acara
@endsection
@section('page')
    Berita Acara
@endsection



@section('content')
<div class="card mb-5 mb-xl-10">
    <form action="{{ route('v-prov.BA')}}" method="POST" target="_blank">
    @csrf
    <div class="card-header justify-content-between">
        <div class="card-title">
            <h3>
                Input Data Berita Acara
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row text-start">
                                                    
            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="achievement" class="form-label">Nama Kab/Kota</label>
                    <input type="text" value="{{ $district->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="ba_bappeda_prov" class="form-label">Nama Penandatangan Bappeda Provinsi</label>
                    <select 
                        id="ba_bappeda_prov" 
                        name="ba_bappeda_prov" 
                        aria-label="Default select example"
                        class="form-select form-select-solid rounded rounded-4" 
                        required
                        autocomplete="off"
                        autofocus
                    >
                    <option value="" disabled selected></option>
                    @foreach($bappeda as $data)
                        <option value="{{ $data->id }}">
                            {{$data->name}}
                        </option>
                    @endforeach
                    </select>
                    
                    @error('ba_bappeda_prov')
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
                    <label for="ba_dinkes_prov" class="form-label">Nama Penandatangan Dinkes Provinsi</label>
                    <select 
                        id="ba_dinkes_prov" 
                        name="ba_dinkes_prov" 
                        aria-label="Default select example"
                        class="form-select form-select-solid rounded rounded-4" 
                        required
                        autocomplete="off"
                        autofocus
                    >
                    <option value="" disabled selected></option>
                    @foreach($dinkes as $data)
                        <option value="{{ $data->id }}">
                            {{$data->name}}
                        </option>
                    @endforeach
                    </select>
                    
                    @error('ba_dinkes_prov')
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
                    <label for="skpd_prov" class="form-label">Nama SKPD Provinsi</label>
                    <select 
                        id="skpd_prov" 
                        name="skpd_prov" 
                        aria-label="Default select example"
                        class="form-select form-select-solid rounded rounded-4" 
                        required
                        autocomplete="off"
                        autofocus
                    >
                    <option value="" disabled selected></option>
                    @foreach($skpd as $data)
                        <option value="{{ $data->id }}">
                            {{$data->name}}
                        </option>
                    @endforeach
                    </select>
                    
                    @error('skpd_prov')
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
                    <label for="nama_skpd_prov" class="form-label">Nama Perwakilan SKPD</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Nama" name="nama_skpd_prov" id="nama_skpd_prov">
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="jb_skpd_prov" class="form-label">Jabatan Perwakilan SKPD</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Jabatan" name="jb_skpd_prov" id="jb_skpd_prov">
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="nama_bappeda_kab_kota" class="form-label">Nama Perwakilan Bappeda Kab/Kota</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Nama" id="nama_bappeda_kab_kota" name="nama_bappeda_kab_kota">
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="jb_bappeda_kab_kota" class="form-label">Jabatan Perwakilan Bappeda Kab/Kota</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Jabatan" id="jb_bappeda_kab_kota" name="jb_bappeda_kab_kota">
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="nama_dinkes_kab_kota" class="form-label">Nama Perwakilan Dinkes Kab/Kota</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Nama" id="nama_dinkes_kab_kota" name="nama_dinkes_kab_kota">
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="jb_dinkes_kab_kota" class="form-label">Jabatan Perwakilan Dinkes Kab/Kota</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Jabatan" name="jb_dinkes_kab_kota" id="jb_dinkes_kab_kota">
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="nama_forum_kab_kota" class="form-label">Nama Perwakilan Forum Kab/Kota</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Nama" id="nama_forum_kab_kota" name="nama_forum_kab_kota">
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="form-group w-100">
                    <label for="jb_forum_kab_kota" class="form-label">Jabatan Perwakilan Forum Kab/Kota</label>
                    <input type="text" required class="form-control form-control-solid rounded rounded-4" placeholder="Jabatan" name="jb_forum_kab_kota" id="jb_forum_kab_kota">
                </div>
            </div>
            <input value="{{ $district->id  }}" name="kota" hidden>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        &nbsp;
        <a href="{{route('v-prov.indexBA',)}}" class="btn btn-sm btn-secondary">
            Kembali
        </a>
    </div>
    </form>
</div>
@endsection


@section('script')
<script>
        $('#ba_bappeda_prov').select2({
            placeholder: 'Pilih',
            allowClear: true
        });
        $('#ba_dinkes_prov').select2({
            placeholder: 'Pilih',
            allowClear: true
        });
        $('#skpd_prov').select2({
            placeholder: 'Pilih',
            allowClear: true
        });
</script>
@endsection
