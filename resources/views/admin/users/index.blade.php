@extends('partials.index')
@section('heading')
    User
@endsection
@section('page')
    Data User
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar User
                </h3>
                
            </div>
        </div>
        <div class="card-body">
            <a href="{{route('user.create')}}">
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="nav-icon fas fa-folder-plus "></i>Tambah
                </button>
            </a>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered border" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-200px text-center border-1 border"></th>
                            <th class="border-1 border">Role Akses</th>
                            <th class="border-1 border">Kab/Kota</th>
                            <th class="border-1 border">Username</th>
                            <th class="border-1 border">Session</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-1">
                                    <a href="{{ route('user.edit', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-warning w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#resetPassword{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-key"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade" tabindex="-1" id="resetPassword{{ $data->id }}">
                                        <form action="{{ route('user.resetPassword', $data->id) }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Reset Password</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah yakin ingin mereset password ke default "sumbarprov"?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-4">Reset Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    
                                    <div class="modal fade" tabindex="-1" id="confirmDelete{{ $data->id }}">
                                        <form action="{{ route('user.destroy', $data->id) }}" method="POST">
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
                                                        <p>Apakah yakin ingin menghapus data?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-4">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <a href="{{ route('user.resetSession', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-rotate-right"></i>
                                        </div>
                                    </a>
                                </td>
                                <td class="text-capitalize border border-1">{{ $data->_group->name }}</td>
                                <td class="text-capitalize border border-1">{{ $data->_zona->name ?? '-' }}</td>
                                <td class="text-capitalize border border-1">{{ $data->username }}</td>
                                <td class="border border-1">{{ $data->session ?? '-' }}</td>

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
            "pageLength": 100,
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
