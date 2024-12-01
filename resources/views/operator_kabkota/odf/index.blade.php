@extends('partials.index')
@section('heading')
Data ODF
@endsection
@section('page')
Data ODF 
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Kelengkapan ODF</h3>
            </div>
            @if($odf && $odf->id)
                <a href="{{ route('odf.editKabKota', $odf->id) }}" class="btn btn-primary btn-sm align-self-center">Edit Data</a>
            @else
                <a href="{{ route('odf.createKabKota') }}" class="btn btn-primary btn-sm align-self-center">Edit Data</a>
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Persentase ODF (%)</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-bold fs-6 text-gray-800">{{$odf->percentage ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Usulan Swastisaba</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6" >{{$odf->_proposal->name ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nama Dokumen</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{$odf->path ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Bukti Dokumen</label>
                <div class="col-lg-9 fv-row">
                    @if (!empty($odf) && !is_null($odf->path))
                        <a href="{{ asset('uploads/doc_odf/'.$odf->path) }}" target="_blank" class="btn btn-success btn-sm">
                            Lihat
                        </a>
                    @else
                        Belum Ada
                    @endif
                    
                    {{-- <span class="fw-semibold text-gray-800 fs-6">{{$odf->path ?? 'Belum ada'}}</span> --}}
                </div>
            </div>
            
        </div>
    </div>
@endsection
