@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Pertanyaan</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="lead">Kategori Soal : {{$category->name}}</p>
            {{-- <p class="lead"></p> --}}
            <div class="row">
                <div class="col-lg-6">
                    {{-- <a href="{{ route('questions.index')}}">
                        <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                            <i class="nav-icon fas fa-arrow-left"></i>Kembali
                        </button>
                    </a> --}}
                    <a href="{{ route('category-postest.createQuestion', $category->id) }}">
                        <button type="button" class="btn btn-primary btn-sm ms-4">
                            <i class="nav-icon fas fa-folder-plus "></i>Tambah
                        </button>
                    </a>
                    {{-- <a href="{{route('questions.import', $category->id)}}">
                        <button type="button" class="btn btn-success btn-sm ms-4">
                            <i class="fa-solid fa-file-export"></i>Import
                        </button>
                    </a> --}}
                </div>
                
            </div>
            <div class="table-responsive">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-125px border-1 border"></th>
                            <th class="border-1 border w-25">Pertanyaan</th>
                            <th class="border-1 border w-150px">Opsi A</th>
                            <th class="border-1 border w-150px">Opsi B</th>
                            <th class="border-1 border w-150px">Opsi C</th>
                            <th class="border-1 border w-150px">Opsi D</th>
                            <th class="border-1 border w-60px">Jawaban Benar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $data)
                            <tr>
                                <td class="text-center border-1 border">{{ $loop->iteration }}</td>
                                <td class="border-1 border text-center">
                                    <a href="{{ route('category-postest.editQuestion', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
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
                                        <form action="{{ route('category-postest.destroyQuestion', $data->id) }}" method="POST">
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
                                <td class="border-1 border">
                                    {!! str_replace('<img', '<img style="max-width:100px;height:auto;"', $data->question) !!}
                                </td>
                                <td class="border-1 border">
                                    {!! str_replace('<img', '<img style="max-width:100px;height:auto;"', $data->opt_a) !!}
                                </td>
                                <td class="border-1 border">
                                    {!! str_replace('<img', '<img style="max-width:100px;height:auto;"', $data->opt_b) !!}
                                </td>
                                <td class="border-1 border">
                                    {!! str_replace('<img', '<img style="max-width:100px;height:auto;"', $data->opt_c) !!}
                                </td>
                                <td class="border-1 border">
                                    {!! str_replace('<img', '<img style="max-width:100px;height:auto;"', $data->opt_d) !!}
                                </td>
                                <td class="border-1 border text-center">{{ $data->opt_correct }}</td>
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
            "pageLength" : 100,
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
