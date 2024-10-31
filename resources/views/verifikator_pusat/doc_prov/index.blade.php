@extends('partials.index')
@section('heading')
    Dokumen Provinsi
@endsection
@section('page')
    Dokumen Provinsi
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Dokumen Provinsi
                </h3>
            </div>
        </div>
        <div class="card-body">
            <p class="lead">Kategori : {{$doc->name}}</p>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1 text-center align-middle p-3" rowspan="2">No.</th>
                            <th class="border border-1 align-middle p-3" rowspan="2">Nama Dokumen</th>
                            <th class="border border-1 align-middle p-3" rowspan="2">Dokumen</th>
                            <th class="border border-1 align-middle text-center p-3" rowspan="2">Status</th>
                            <th class="border border-1 text-center p-3" colspan="2">Assesment Pusat</th>
                            <th class="border border-1 align-middle p-3" rowspan="2">Aksi   </th>

                            {{-- <th class="border border-1">Assesment Pusat</th>
                            <th class="border border-1">Aksi</th> --}}
                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sub_doc as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border border-1">{{ $data->name }}</td>
                                @php
                                    $relatedAnswerDoc = $answer_doc->where('id_sub_doc_prov', $data->id)->first();
                                @endphp
                                @if ($relatedAnswerDoc)
                                    <td class="border border-1 text-center">
                                        <a href="{{ asset($relatedAnswerDoc->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-eye"></i>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="border border-1">
                                        <div class="badge badge-light-success">Sudah upload</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        @if(is_null($relatedAnswerDoc->is_pusat))
                                            Belum dijawab
                                        @elseif($relatedAnswerDoc->is_pusat == 1)
                                            Sesuai
                                        @elseif($relatedAnswerDoc->is_pusat == 2)
                                            Tidak Sesuai
                                        @endif
                                    </td>
                                    <td class="border border-1 text-center">
                                        @if(is_null($relatedAnswerDoc->comment_pusat))
                                            Belum dijawab
                                        @else
                                            {{$relatedAnswerDoc->comment_pusat}}
                                        @endif
                                    </td>
                                @else
                                    <td class="border border-1 text-center">
                                       -
                                    </td>
                                    <td class="border border-1">
                                        <div class="badge badge-light-danger">Belum upload</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        <div class="badge badge-light-danger">Tidak ada</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        <div class="badge badge-light-danger">Tidak ada</div>
                                    </td>
                                @endif
                                
                                <td class="border border-1">
                                    <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $data->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade" tabindex="-1" id="confirmUpdate{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <form action="{{ route('v-pusat.storeDataProv', $data->id)}}" method="POST">
                                        {{-- <form action="" method="POST"> --}}
                                            @csrf
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">
                                                            Edit Verifikasi Dokumen Provinsi
                                                        </h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <strong>Nama Dokumen:</strong> 
                                                        </p>
                                                        <p>{{ $data->name }}</p> 
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="is_pusat" id="optionSesuai" value="1" {{ isset($relatedAnswerDoc) && $relatedAnswerDoc->is_pusat == 1 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="optionSesuai">Sesuai</label>
                                                        </div>
                                                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="is_pusat" id="optionTidakSesuai" value="2" {{ isset($relatedAnswerDoc) && $relatedAnswerDoc->is_pusat == 2 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="optionTidakSesuai">Tidak sesuai</label>
                                                        </div>
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label bold">Komentar</label>
                                                                    @if (!empty($relatedAnswerDoc->comment_pusat))
                                                                        <textarea name="comment_pusat" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar">{{$relatedAnswerDoc->comment_pusat}}</textarea>
                                                                    @else
                                                                        <textarea name="comment_pusat" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar"></textarea>
                                                                    @endif
                                                                    
                                                                    @error('comment_pusat')
                                                                        <div class="is-invalid">
                                                                            <span class="text-danger">
                                                                                {{$message}}
                                                                            </span>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-4">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
