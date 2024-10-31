@extends('partials.index')
@section('heading')
    {{$zona->name}}
@endsection
@section('page')
    Data Pertanyaan
@endsection


@section('content')
   

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>{{$category->name}}</h3>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('v-prov.indexKelembagaan', $zona->id)}}">
                <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>Kembali
                </button>
            </a>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border align-middle p-3" rowspan="2">No.</th>
                            <th class="w-150px text-center border-1 border align-middle p-3" rowspan="2">Bagian</th>
                            <th class="w-150px text-center border-1 border align-middle p-3" rowspan="2">Pertanyaan</th>

                            <th class="w-200px text-center border-1 border align-middle" colspan="3">Self Assesment</th>
                            <th class="w-200px text-center border-1 border align-middle" colspan="2">Provinsi</th>
                            <th class="w-100px text-center border-1 border align-middle" colspan="2">Pusat</th>
                            <th class=" w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>

                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Jawaban</th>
                            <th class="text-center border-1 border align-middle p-3">Dokumen</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>

                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>

                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                        </tr>
                    </thead>
                   <tbody>
                        @foreach ($questions as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->question }}</td>
                            <td class="border-1 border p-3">{{ $item->opsi }}</td>
                            
                            @php
                                $relatedAnswer = $answer->where('id_q_kelembagaan', $item->id)->first();
                                $uploadedFile = $uploadedFiles->where('id_q_kelembagaan', $item->id);
                            @endphp

                            @if ($relatedAnswer)
                                <td class="border-1 border p-3">
                                    @if ($relatedAnswer->answer == 1)
                                        Ada
                                    @else
                                        Tidak ada
                                    @endif
                                </td>

                                @if ($uploadedFile->isNotEmpty())
                                    @foreach ($uploadedFile as $file)
                                        <td class="text-center border border-1 p-3">
                                            <a href="{{ asset($file->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                                <div class="d-flex justify-content-center">
                                                    <i class="fa-solid fa-eye"></i>
                                                </div>
                                            </a>
                                        </td>
                                    @endforeach
                                @else
                                    <td class="border border-1 p-3 text-center">
                                        Tidak ada dokumen
                                    </td>
                                @endif

                                <td class="text-center border border-1 p-3">
                                    <div class="badge badge-light-success">Sudah dijawab</div>
                                </td>
                                

                                <td class="border-1 border p-3">
                                    @if ($relatedAnswer->answer_prov == 1)
                                        Ada
                                    @elseif($relatedAnswer->answer_prov == 2)
                                        Tidak ada
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-1 border p-3">
                                    {{$relatedAnswer->comment_prov ?? '-'}}
                                </td>

                                <td class="border-1 border p-3">
                                    @if ($relatedAnswer->answer_pusat == 1)
                                        Ada
                                    @elseif($relatedAnswer->answer_pusat == 2)
                                        Tidak ada
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-1 border p-3">
                                    {{$relatedAnswer->comment_pusat?? '-'}}
                                </td>
                                
                            @else
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">
                                    <div class="badge badge-light-danger">Belum dijawab</div>
                                </td>

                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">
                                    <div class="badge badge-light-danger">Belum dijawab</div>
                                </td>

                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">
                                    <div class="badge badge-light-danger">Belum dijawab</div>
                                </td>
                            @endif

                            <td class="border border-1">
                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                                <div class="modal fade" tabindex="-1" id="confirmUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <form action="{{ route('v-prov.storeKelembagaan', ['id_zona' => $zona->id, 'id' => $item->id])}}" method="POST">
                                        @csrf
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Edit Verifikasi Pertanyaan
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <strong>Pertanyaan:</strong> 
                                                    </p>
                                                    <p>{{ $item->opsi }}</p> 
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="answer_prov" id="optionAda" value="1" {{ isset($relatedAnswer) && $relatedAnswer->answer_prov == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="optionAda">Ada</label>
                                                    </div>
                                            
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="answer_prov" id="optionTidakAda" value="2" {{ isset($relatedAnswer) && $relatedAnswer->answer_prov == 2 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="optionTidakAda">Tidak Ada</label>
                                                    </div>
                                                    <div class="row mb-3 mt-3">
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="name" class="form-label bold">Komentar</label>
                                                                @if (!empty($relatedAnswer->comment_prov))
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar">{{$relatedAnswer->comment_prov}}</textarea>
                                                                @else
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar"></textarea>
                                                                @endif
                                                                
                                                                @error('comment_prov')
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
