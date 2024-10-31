@extends('partials.index')
@section('heading')
    Tatanan
@endsection
@section('page')
    Data Tatanan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Sampah Tatanan
                </h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableTrash" class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px">No.</th>
                            <th class="w-100px"></th>
                            <th>Nama Tatanan</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashedData as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('category.restore', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fas fa-trash-restore"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade" tabindex="-1" id="confirmDelete{{ $data->id }}">
                                        <form action="{{ route('category.forceDelete', $data->id) }}">
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
                                <td class="text-capitalize">{{ $data->name }}</td>
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
