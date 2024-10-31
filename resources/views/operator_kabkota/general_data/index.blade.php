@extends('partials.index')
@section('heading')
Data Umum
@endsection
@section('page')
Data Umum 
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Kelengkapan Data Umum</h3>
            </div>
            @if($g_data && $g_data->id)
                <a href="{{ route('g-data.editKabKota', $g_data->id) }}" class="btn btn-primary btn-sm align-self-center">Edit Data</a>
            @else
                <a href="{{ route('g-data.createKabKota') }}" class="btn btn-primary btn-sm align-self-center">Edit Data</a>
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nama Kabupaten Kota</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-bold fs-6 text-gray-800">{{$g_data->_zona->name ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nama Walikota/Bupati</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6" >{{$g_data->nama_wako_bup ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Alamat Kantor Walikota/Bupati</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{$g_data->alamat_kantor ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nama Pembina</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{$g_data->nama_pembina ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nama Forum</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{$g_data->nama_forum ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nama Ketua Forum</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6 text-capitalize">{{$g_data->nama_ketua_forum ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Alamat Kantor Forum</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6 text-capitalize">{{$g_data->alamat_kantor_forum ?? 'Belum ada'}}</span>
                </div>
            </div>
            {{-- <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Dokumen Surat Minat</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6 text-capitalize">{{$g_data->doc_surat_minat ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Dokumen ODF</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6 text-capitalize">{{$g_data->doc_odf ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Dokumen Akses Jamban</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6 text-capitalize">{{$g_data->doc_akses_jamban ?? 'Belum ada'}}</span>
                </div>
            </div> --}}

            {{-- <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Id</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6 text-capitalize" id="idUser"></span>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#tableSKPD").DataTable({
            responsive: true,
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom":
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
@endsection
