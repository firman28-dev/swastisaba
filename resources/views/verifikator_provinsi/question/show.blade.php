@extends('partials.index')
@section('heading')
    {{$zona->name}}
@endsection
@section('page')
    Data Pertanyaan
@endsection


@section('content')
    @php
        $totalQuestion = $questions->count();
        $answerSuccess = $answer->where('id_category', $category->id)->count();

        $maxScrore = $totalQuestion*100;
        $yourScore = \DB::table('trans_survey_d_answer')
                    ->join('m_question_options', 'trans_survey_d_answer.id_option', '=', 'm_question_options.id')
                    ->where('trans_survey_d_answer.id_category', $category->id)
                    ->sum('m_question_options.score');
        // dd($yourScore);
    @endphp

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Tatanan {{$category->name}}</h3>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('v-prov.index', $zona->id)}}">
                <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>Kembali
                </button>
            </a>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border p-3" rowspan="2">No.</th>
                            <th class="w-150px text-center border-1 border align-middle p-3" rowspan="2">Pertanyaan</th>
                            <th class="w-200px text-center border-1 border align-middle" colspan="3">Self Assesment</th>
                            <th class="w-200px text-center border-1 border align-middle" colspan="3">Provinsi</th>
                            <th class="w-100px text-center border-1 border align-middle" colspan="3">Pusat</th>
                            <th class=" w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>

                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>

                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>

                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->name }}</td>
                            @php
                                $relatedAnswer = $answer->where('id_question', $item->id)->first();

                            @endphp

                            @if ($relatedAnswer)
                                <td class="border-1 border p-3">{{ $relatedAnswer->_q_option->name }}</td>
                                <td class="border-1 border text-center p-3">{{ $relatedAnswer->_q_option->score }}</td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-success">Sudah dijawab</div>
                                </td>

                                <td class="border-1 border p-3">{{ $relatedAnswer->_q_option_prov->name?? '-' }}</td>
                                <td class="border-1 border text-center p-3">{{ $relatedAnswer->_q_option_prov->score??'-'}}</td>
                                <td class="border-1 border p-3">
                                    @if($relatedAnswer && $relatedAnswer->comment_prov)
                                        {{ $relatedAnswer->comment_prov }}
                                    @else
                                        <div class="badge badge-light-danger">Belum dijawab</div>
                                    @endif
                                </td>

                                <td class="border-1 border p-3">{{ $relatedAnswer->_q_option_pusat->name?? '-' }}</td>
                                <td class="border-1 border text-center p-3">{{ $relatedAnswer->_q_option_pusat->score??'-'}}</td>
                                <td class="border-1 border p-3">
                                    @if($relatedAnswer && $relatedAnswer->comment_pusat)
                                        {{ $relatedAnswer->comment_pusat }}
                                    @else
                                        <div class="badge badge-light-danger">Belum dijawab</div>
                                    @endif
                                </td>
                            @else
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">
                                    <div class="badge badge-light-danger">Belum dijawab</div>
                                </td>

                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>

                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                            @endif

                            <td>
                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        {{-- <i class="fas fa-pen-nib"></i> --}}
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                                <div class="modal modal-lg fade modal-dialog-scrollable" tabindex="-1" id="confirmUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <form action="{{ route('v-prov.store', ['id' => $item->id, 'id_zona' => $zona->id])}}" method="POST">
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
                                                    <p>{{ $item->name }}</p> 
                                                    <table class="table table-bordered mb-4 border">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-1 border">Opsi Jawaban</th>
                                                                <th class="border-1 border">Nilai Jawaban</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $relatedAnswer = $answer->where('id_question', $item->id)->first();
                                                            @endphp
                                                            
                                                            @if ($relatedAnswer && $relatedAnswer->id_option_prov)
                                                                @foreach ($item->_q_option as $opsi)
                                                                <tr>
                                                                    <td class="border-1 border">
                                                                        <div class="form-check">
                                                                            <input 
                                                                                class="form-check-input" 
                                                                                type="radio" 
                                                                                name="id_option_prov" 
                                                                                value="{{ $opsi->id }}" 
                                                                                @if($relatedAnswer->id_option_prov == $opsi->id) checked @endif
                                                                                required
                                                                            >
                                                                            <label class="form-check-label" for="name_option">{{ $opsi->name }}</label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="border-1 border">
                                                                        <label class="form-check-label">{{ $opsi->score }}</label>
                                                                    </td>
                                                                </tr>

                                                                @endforeach
                                                            @else
                                                           
                                                                @foreach ($item->_q_option as $opsi)
                                                                <tr>
                                                                    <td class="border-1 border">
                                                                        <div class="form-check">
                                                                            <input 
                                                                                class="form-check-input" 
                                                                                type="radio" 
                                                                                name="id_option_prov" 
                                                                                value="{{ $opsi->id }}" 
                                                                                required
                                                                            >
                                                                            <label class="form-check-label" for="name_option">{{ $opsi->name }}</label>
                                                                        </div>

                                                                    </td>
                                                                    <td class="border-1 border">
                                                                        <label class="form-check-label">{{ $opsi->score }}</label>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                               
                                                            @endif
                                                            
                                                            

                                                        </tbody>
                                                    </table>

                                                    <div id="dynamic-input-pdf mb-4 ">
                                                        <label for="opsi" class="form-label">Data Pendukung</label>
                                                        @php
                                                            $docQuestions = \App\Models\Doc_Question::where('id_question', $item->id)->get();
                                                        @endphp
                                                        <table class="table mb-3 table-striped table-row-bordered border rounded">
                                                            <thead>
                                                                <tr>
                                                                    <th class="border border-1">Nama Data</th>
                                                                    <th class="w-200px border border-1 text-center">Status</th>
                                                                    <th class="border border-1">Dokumen</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($docQuestions as $doc)
                                                                    <td class="border border-1">{{$doc->name}}</td>
                                                                    @php
                                                                        // Ambil dokumen yang sesuai dengan Doc_Question yang sedang di-loop
                                                                        $uploadedFile = $uploadedFiles->where('id_doc_question', $doc->id);
                                                                    @endphp
                                                                    @if ($uploadedFile->isNotEmpty())
                                                                        <td class="border border-1 text-success text-center">
                                                                            <div class="badge badge-light-success">Ada</div>
                                                                        </td>
                                                                        <td class="border border-1 text-center">
                                                                            <!-- Menampilkan link untuk setiap dokumen yang tersedia -->
                                                                            @foreach ($uploadedFile as $file)
                                                                                <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                                                                    <i class="fa-solid fa-eye"></i>
                                                                                </a>
                                                                            @endforeach
                                                                        </td>
                                                                    @else
                                                                        <td class="border border-1 text-center">
                                                                            <div class="badge badge-light-danger">Tidak ada</div>
                                                                        </td>
                                                                        <td class="border border-1 text-center">
                                                                            -
                                                                        </td>
                                                                    @endif
                                                                    @endforeach
                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>

                                                    @if ($relatedAnswer && $relatedAnswer->id_option_prov)
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label">Komentar</label>
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar">{{$relatedAnswer->comment_prov}}</textarea>
                                                                    
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
                                                    @else
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label">Komentar</label>
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar"></textarea>
                                                                    
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
                                                    @endif
                                                    

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
