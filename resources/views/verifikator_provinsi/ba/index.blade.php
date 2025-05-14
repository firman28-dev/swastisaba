@extends('partials.index')
@section('heading')
    Berita Acara
@endsection
@section('page')
    Berita Acara
@endsection



@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-header justify-content-between">
        <div class="card-title">
            <h3>
                Daftar Kab/Kota
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive mt-3">
            <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                <thead>
                    <tr class="fw-semibold fs-6 text-muted">
                        <th class="w-60px border border-1 text-center p-3 align-middle">No.</th>
                        <th class="w-200px border border-1">Nama Kab/Kota</th>
                        <th class="w-200px border border-1">Tipe</th>
                        <th class="w-200px border border-1 text-center">Status Berita Acara</th>
                        <th class="w-200px border border-1 text-center">Aksi</th>
                    </tr>
                   
                </thead>
                <tbody>
                    @foreach ($district as $item)
                        <tr>
                            <td class="text-center border border-1">{{ $loop->iteration }}</td>
                            <td class="border border-1">{{ $item->name }}</td>
                            <td class="border border-1">{{ $item->area_type_id == 1 ? 'Kabupaten' : ($item->area_type_id == 2 ? 'Kota' : '') }}</td>
                            {{-- <td class="text-center border border-1">
                                <button class="btn btn-success btn-outline btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cetak{{$item->id}}">
                                    <div class="d-flex justify-content-center">
                                        <i class="fa-solid fa-print"></i> Cetak
                                    </div>
                                </button>
                                <div class="modal modal-lg fade modal-dialog-scrollable" tabindex="-1" id="cetak{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <form action="{{ route('v-prov.BA')}}" method="POST" target="_blank">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Input Berita Acara
                                                    </h3>
                                                </div>
                                               <div class="modal-body">
                                                <div class="row text-start">
                                                    
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="form-group w-100">
                                                            <label for="achievement" class="form-label">Nama Kab/Kota</label>
                                                            <input type="text" value="{{ $item->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="form-group w-100">
                                                            <label for="ba_bappeda_prov" class="form-label">Nama Penandatangan Bappeda Provinsi</label>
                                                            <select 
                                                                id="ba_bappeda_prov" 
                                                                name="ba_bappeda_prov" 
                                                                aria-label="Default select example"
                                                                class="form-select form-select-solid rounded rounded-4 select2" 
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

                                                    <input value="{{ $item->id  }}" name="kota" hidden>

                                                   
                                                </div>
                                               </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                                    <button type="submit" class="btn btn-primary rounded-4">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td> --}}
                           
                            <td class="border border-1 text-center">
                                @php
                                    $ba_general = \App\Models\BA_General::where('zona_id', $item->id)->first();
                                @endphp
                                 @if ($ba_general)
                                    <span class="badge badge-success"><i class="fa-solid fa-check text-white "></i></span>
                                @else
                                    <span class="badge badge-danger"><i class="fa-solid fa-xmark text-white"></i></span>
                                @endif
                            </td>
                            <td class="border border-1 text-center">
                                <a href="{{route('v-prov.indexFirstBAGeneral',$item->id)}}">
                                    <button type="button" class="btn btn-outline-success btn-outline btn-sm">
                                        <i class="fa-solid fa-print"></i> Lihat BA
                                    </button>
                                </a>
                                &nbsp;
                                <a href="{{route('v-prov.printBAGeneral',$item->id)}}" target="_blank">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-print"></i> Cetak
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
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
