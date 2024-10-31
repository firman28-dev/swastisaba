@extends('partials.index')
@section('heading')
    Dokumen Provinsi
@endsection
@section('page')
    Data Dokumen Provinsi
@endsection

@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Kategori Dokumen Provinsi</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableSKPD" class="table table-striped table-row-bordered border" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border border-1">No.</th>
                            <th class="border border-1">Kategori</th>
                            <th class="w-300px border border-1"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                               
                                <td class="text-capitalize border border-1">{{ $data->name }}</td>
                                <td class="border border-1">
                                    <a href="{{route('showSubDoc',$data->id)}}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat Sub Kategori
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
