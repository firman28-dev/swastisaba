@extends('partials.index')
@section('heading')
    Opsi Pertanyaan
@endsection
@section('page')
    Data Opsi Pertanyaan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Opsi Pertanyaan</h3>
                
            </div>
        </div>
        <div class="card-body">
            <p class="lead">Indikator : </p>
            <p>{{$question_kelembagaan->indikator}}</p>
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('showQKelembagaanNew', $question_kelembagaan->id_c_kelembagaan_v2  ) }}">
                        <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                            <i class="nav-icon fas fa-arrow-left"></i>Kembali
                        </button>
                    </a>
                    &nbsp;
                    <a href="{{route('q-opt-kelembagaan.create', $question_kelembagaan->id)}}">
                        <button type="button" class="btn btn-primary btn-sm">
                            <i class="nav-icon fas fa-folder-plus "></i>Tambah
                        </button>
                    </a>
                </div>
                
            </div>
            
            <div class="table-responsive">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-100px border-1 border"></th>
                            <th class="border-1 border">Opsi</th>
                            <th class="border-1 border w-250px">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($q_option_kelembagaan as $data)
                            <tr>
                                <td class="text-center border-1 border">{{ $loop->iteration }}</td>
                                <td class="border-1 border">
                                    <a href="{{ route('q-opt-kelembagaan.edit', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade" tabindex="-1" id="confirmDelete{{ $data->id }}">
                                        <form action="{{ route('q-opt-kelembagaan.destroy', $data->id) }}" method="POST">
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
                                </td>
                                <td class="text-capitalize border-1 border">{{ $data->name }}</td>
                                <td class="text-capitalize border-1 border">{{ $data->score }}</td>


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
