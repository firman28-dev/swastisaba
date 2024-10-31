@extends('partials.index')
@section('heading')
    Pertanyaan Kelembagaan
@endsection
@section('page')
    Data Pertanyaan Kelembagaan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Pertanyaan Kelembagaan</h3>
                
            </div>
        </div>
        <div class="card-body">
            <p class="lead">Kategori Kelembagaan : </p>
            <p>{{$c_kelembagaan_v2->name}}</p>
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('q-kelembagaan-v2.index')}}">
                        <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                            <i class="nav-icon fas fa-arrow-left"></i>Kembali
                        </button>
                    </a>
                    &nbsp;
                    <a href="{{route('q-kelembagaan-v2.create', $c_kelembagaan_v2->id)}}">
                        <button type="button" class="btn btn-primary btn-sm ms-4">
                            <i class="nav-icon fas fa-folder-plus "></i>Tambah
                        </button>
                    </a>
                </div>
                
            </div>
            <div class="table-responsive">
                <table id="tableSKPD" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-100px border-1 border"></th>
                            <th class="w-150px border-1 border">Indikator</th>
                            <th class=" border-1 border">Definisi Operasional</th>
                            <th class=" border-1 border">Sumber Data</th>
                            <th class=" border-1 border">Data Dukung</th>
                            <th class="w-100px border-1 border"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($q_kelembagaan_v2 as $data)
                            <tr>
                                <td class="text-center border-1 border text-lg-center">{{ $loop->iteration }}</td>
                                <td class="border-1 border text-center">
                                    <a href="{{ route('q-kelembagaan-v2.edit', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade text-start" tabindex="-1" id="confirmDelete{{ $data->id }}">
                                        <form action="{{ route('q-kelembagaan-v2.destroy', $data->id) }}" method="POST">
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
                                <td class="text-capitalize border-1 border">{{ $data->indikator }}</td>
                                <td class="text-capitalize border-1 border">{{ $data->d_operational }}</td>
                                <td class="text-capitalize border-1 border">{{ $data->s_data }}</td>
                                <td class="text-capitalize border-1 border">{{ $data->data_dukung }}</td>
                                <td class="border-1 border">
                                    <a href="{{route('q-opt-kelembagaan.index',$data->id)}}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat Opsi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        
    </div>

    <div class="card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Kegiatan</h3>
            </div>
        </div>
        <div class="card-body">
            
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
