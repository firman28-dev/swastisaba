@extends('partials.index')
@section('heading')
    {{$zona->name}}
@endsection
@section('page')
    Dokumen Narasi Tatanan KabKota
@endsection


@section('content')
   
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Dokumen Narasi Tatanan</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border align-middle p-3" rowspan="2">No.</th>
                            <th class="w-200px text-center border-1 border align-middle p-3" rowspan="2">Nama Dokumen </th>
                            <th class="w-100px text-center border-1 border align-middle p-3" rowspan="2">Bukti</th>
                            <th class="w-150px text-center border-1 border align-middle p-3" colspan="2">Assesment Provinsi</th>
                            <th class="w-150px text-center border-1 border align-middle p-3" colspan="2">Assesment Pusat</th>
                            <th class="w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>
                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>

                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3 w-50px">Keterangan</th>
                        </tr>
                    </thead>
                   <tbody>
                        @foreach ($category as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->name }}</td>
                            @php
                                $answerDoc = $doc->where('id_category', $item->id)->first();
                            @endphp
                            @if ($answerDoc)
                                <td class="border-1 border p-3 text-center">
                                    <a href="{{ asset('uploads/doc_narasi/'.$answerDoc->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-eye"></i>
                                        </div>
                                    </a>
                                </td>
                                <td class="border-1 border p-3 text-center">
                                    @if($answerDoc && $answerDoc->is_prov)
                                        @if ($answerDoc->is_prov == 1)
                                            Sesuai
                                        @else
                                            Tidak sesuai
                                        @endif
                                    @else
                                        <div class="badge badge-light-info">Belum dijawab</div>
                                    @endif
                                </td>

                                <td class="border-1 border p-3 text-center">
                                    @if($answerDoc && $answerDoc->comment_prov)
                                        {{$answerDoc->comment_prov}}
                                    @else
                                        <div class="badge badge-light-info">Belum dijawab</div>
                                    @endif
                                </td>

                                <td class="border-1 border p-3 text-center">
                                    @if($answerDoc && $answerDoc->is_pusat)
                                        @if ($answerDoc->is_pusat == 1)
                                            Sesuai
                                        @else
                                            Tidak sesuai
                                        @endif
                                    @else
                                        <div class="badge badge-light-info">Belum dijawab</div>
                                    @endif
                                </td>

                                <td class="border-1 border p-3 text-center w-20px">
                                    @if($answerDoc && $answerDoc->comment_pusat)
                                        {{$answerDoc->comment_pusat}}
                                    @else
                                        <div class="badge badge-light-info">Belum dijawab</div>
                                    @endif
                                </td>
                                <td class="text-center p-3 border border-1">
                                    <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $item->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade" tabindex="-1" id="confirmUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <form action="{{ route('v-pusat.storeNarasi', $answerDoc->id)}}" method="POST">
                                            @csrf
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">
                                                            Verifikasi Dokumen Umum
                                                        </h3>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <p><strong>{{$item->name}}</strong></p>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="is_pusat" id="optionAda{{$answerDoc->id}}" value="1" {{ isset($answerDoc) && $answerDoc->is_pusat == 1 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="optionAda{{$answerDoc->id}}">Sesuai</label>
                                                        </div>
                                                
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="is_pusat" id="optionTidakAda{{$answerDoc->id}}" value="2" {{ isset($answerDoc) && $answerDoc->is_pusat == 2 ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="optionTidakAda{{$answerDoc->id}}">Tidak Sesuai</label>
                                                        </div>
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label bold">Komentar</label>
                                                                    @if (!empty($answerDoc->comment_pusat))
                                                                        <textarea name="comment_pusat" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required>{{$answerDoc->comment_pusat}}</textarea>
                                                                    @else
                                                                        <textarea name="comment_pusat" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required></textarea>
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
                                                        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-4">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            @else
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Belum diupload</div>
                                </td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Tidak ada</div>
                                </td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Tidak ada</div>
                                </td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Tidak ada</div>
                                </td><td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Tidak ada</div>
                                </td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">-</div>
                                </td>
                            @endif

                            
                        </tr>
                        @endforeach
                   </tbody>
                </table>
            </div>
        </div>
        
    </div>

    <!-- Confirmation Modal -->
    <!-- Toast notifikasi sukses -->

@endsection

@section('script')
    <script>

        $("#tableSKPD").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "pageLength":100,
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
