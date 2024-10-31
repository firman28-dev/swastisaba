

@extends('partials.index')
@section('heading')
Data Kabupaten/Kota
@endsection
@section('page')
Data Kabupaten/Kota 
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Kabupaten/Kota
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="border-1 border">Kab/Kota</th>
                            <th class="border-1 border"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zona as $data)
                            <tr>
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border-1 border">{{ $data->name }}</td>
                                <td class="border-1 border">
                                    <a href="{{route('showGData',$data->id)}}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat Data Umum
                                    </a>
                                    {{-- &nbsp;
                                    <a href="{{route('g-data.create',$data->id)}}" class="btn btn-outline btn-outline-primary btn-sm">
                                        Tambah Data Umum
                                    </a> --}}
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
