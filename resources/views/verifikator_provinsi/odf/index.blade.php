@extends('partials.index')
@section('heading')
Open Defecation Free
@endsection
@section('page')
    Data ODF
@endsection


@section('content')
   
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Data Open Defecation Free</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border align-middle p-3" rowspan="2">No.</th>
                            <th class="w-200px text-center border-1 border align-middle p-3">Nama Kab/Kota </th>
                            <th class="w-200px text-center border-1 border align-middle p-3">Jumlah Kecamatan </th>
                            <th class="w-100px text-center border-1 border align-middle p-3">Jumlah Desa/Kelurahan</th>
                            <th class="w-150px text-center border-1 border align-middle p-3">Jumlah Desa/Kelurahan Stop BABS</th>
                            <th class="w-150px text-center border-1 border align-middle p-3">Pesentase Desa/Kelurahan Stop BABS</th>
                        </tr>
                    </thead>
                   <tbody>
                        @foreach ($zona as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->name }}</td>
                            @php
                                $odf_v2 = $odf->where('id_zona',$item->id)->first()
                            @endphp
                            @if ($odf_v2)
                                <td class="border-1 border p-3 text-center">{{ $odf_v2->sum_subdistricts }}</td>
                                <td class="border-1 border p-3 text-center">{{ $odf_v2->sum_villages }}</td>
                                <td class="border-1 border p-3 text-center">{{ $odf_v2->s_villages_stop_babs }}</td>
                                <td class="border-1 border p-3 text-center">{{ $odf_v2->p_villages_stop_babs }}</td>
                            @else
                                <td class="border-1 border p-3 text-center">-</td>
                                <td class="border-1 border p-3 text-center">-</td>
                                <td class="border-1 border p-3 text-center">-</td>
                                <td class="border-1 border p-3 text-center">-</td>
                            @endif
                        </tr>
                        @endforeach
                   </tbody>
                </table>
            </div>
        </div>
        
    </div>

    <!-- Confirmation Modal -->
    <!-- Toast notifikasi sukses -->

@endsection

@section('script')
    <script>

        $("#tableSKPD").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "pageLength":100,
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
