@extends('partials.index')
@section('heading')
Sub Dokumen Provins
@endsection
@section('page')
    Data Sub Dokumen Provins
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Sampah Sub Dokumen Provins
                </h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableTrash" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1 text-center">No.</th>
                            <th class="w-100px border border-1"></th>
                            <th class="border border-1 p-3">Kategori Provinsi</th>
                            <th class="border border-1 p-3">Sub Kategori Provinsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashedData as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-1 text-center">
                                    <a href="{{ route('sub-doc-prov.restore', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fas fa-trash-restore"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade text-start"  tabindex="-1" id="confirmDelete{{ $data->id }}">
                                        <form action="{{ route('sub-doc-prov.forceDelete', $data->id) }}">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">
                                                            Hapus Data
                                                        </h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah yakin ingin menghapus data secara permanen?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-4">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-capitalize border border-1">{{ $data->_c_doc_prov->name ?? 'Kategori belum direstore' }}</td>
                                <td class="text-capitalize border border-1">{{ $data->name }}</td>
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
        $("#tableTrash").DataTable({
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
