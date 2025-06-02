@extends('partials.index')
@section('heading')
    Profile KabKota
@endsection
@section('page')
    Profile KabKota
@endsection



@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-header justify-content-between">
        <div class="card-title">
            <h3>
                Daftar  Profile KabKota
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
                        <th class="w-200px border border-1 text-center">Status Profile</th>
                        <th class="w-200px border border-1 text-center">Aksi</th>
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
                                    $general_data_2 = $general_data->where('id_zona', $item->id)->first();
                                @endphp
                               @if ($general_data_2)
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-check text-white"></i>
                                    </span>
                                @else
                                    <span class="badge badge-danger"><i class="fa-solid fa-xmark text-white"></i></span>
                                    
                                @endif
                            </td>

                            <td class="border border-1">
                                 <a href="{{route('v-prov.showProfileKabkota',$item->id)}}">
                                    <button type="button" class="btn btn-outline-success btn-outline btn-sm">
                                        <i class="fa-solid fa-print"></i> Lihat Profile
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
