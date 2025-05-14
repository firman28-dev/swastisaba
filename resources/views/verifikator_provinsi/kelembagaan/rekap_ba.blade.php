@extends('partials.index')
@section('heading')
    Berita Acara
@endsection
@section('page')
    Berita Acara Kelembagaan
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
                    </tr>
                   
                </thead>
                <tbody>
                    @foreach ($district as $item)
                        <tr>
                            <td class="text-center border border-1">{{ $loop->iteration }}</td>
                            <td class="border border-1">{{ $item->name }}</td>
                            <td class="border border-1">{{ $item->area_type_id == 1 ? 'Kabupaten' : ($item->area_type_id == 2 ? 'Kota' : '') }}</td>
                           
                            <td class="border border-1 text-center">
                                @php
                                    $ba_general = \App\Models\BA_Kelembagaan::where('id_zona', $item->id)->first();
                                @endphp
                                 @if ($ba_general)
                                    <span class="badge badge-success"><i class="fa-solid fa-check text-white "></i></span>
                                @else
                                    <span class="badge badge-danger"><i class="fa-solid fa-xmark text-white"></i></span>
                                @endif
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
