@extends('partials.index')
@section('heading')
    Kategori Pelatihan
@endsection
@section('page')
    Data Kategori Pelatihan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Kategori Pelatihan
                </h3>
            </div>
        </div>
        <div class="card-body">
            <a href="{{route('category-course.create')}}">
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="nav-icon fas fa-folder-plus "></i>Tambah
                </button>
            </a>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered  border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border border-1">No.</th>
                            <th class="w-100px border border-1"></th>
                            <th class="border border-1">Nama Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        
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
