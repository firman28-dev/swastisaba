@extends('partials.index')
@section('heading')
    Dokumen Data Umum
@endsection
@section('page')
    Dokumen Data Umum
@endsection


@section('content')

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Dokumen Data Umum
                </h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1 text-center p-3 align-middle">No.</th>
                            <th class="w-50 border border-1">Nama Dokumen</th>
                            <th class="w-150px border border-1 text-center">Dokumen Upload</th>
                            <th class="border border-1 text-center">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doc as $data)
                            <tr>
                                <td class="border border-1 text-center p-3">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border border-1 p-3">{{ $data->name }}</td>
                                @php
                                    $relatedAnswerDoc = $answer_doc->where('id_doc_g_data', $data->id)->first();
                                @endphp
                                @if ($relatedAnswerDoc)
                                    <td class="border border-1 text-center">
                                        <div class="badge badge-light-success">Sudah upload</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        <a href="{{ asset($relatedAnswerDoc->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-eye"></i>
                                            </div>
                                        </a>
                                        <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $relatedAnswerDoc->id }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-trash"></i>
                                            </div>
                                        </button>
                                        <div class="modal fade text-start" tabindex="-1" id="confirmDelete{{ $relatedAnswerDoc->id }}">
                                            <form action="{{ route('doc-g-data.destroyKabKota', $relatedAnswerDoc->id) }}" method="POST">
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
                                                            <p>Apakah yakin ingin menghapus data dokumen?</p>
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
                                @else
                                    <td class="border border-1 text-center">
                                        <div class="badge badge-light-danger">Belum upload</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#createModal{{$data->id}}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-square-plus"></i>
                                            </div>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade text-start" tabindex="-1" id="createModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false">>
                                            <form action="{{route('doc-g-data.storeKabKota', $data->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">
                                                                Input Dokumen Data Umum
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input name="id_survey" value="{{session('selected_year')}}" hidden>
                                                            <div class="col-lg-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label">Dokumen</label>
                                                                    <p class="text-danger">Dokumen berbentuk Pdf dan maksimal 2 MB</p>
                                                                    <input type="file" name="path" class="form-control form-control-solid rounded rounded-4" placeholder="File">
                                                                    @error('path')
                                                                        <div class="is-invalid">
                                                                            <span class="text-danger">
                                                                                {{$message}}
                                                                            </span>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary rounded-4">SImpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </td>
                                @endif

                               
                                
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
