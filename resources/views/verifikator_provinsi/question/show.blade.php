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
            &nbsp;
            <button class="btn btn-success btn-outline btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cetak">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-print"></i> Cetak
                </div>
            </button>
            <div class="modal fade modal-dialog-scrollable" tabindex="-1" id="cetak" data-bs-backdrop="static" data-bs-keyboard="false">
                                    
                <div class="modal-dialog modal-dialog-scrollable">
                    <form action="{{ route('v-prov.printPerCategory')}}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">
                                    Input Berita Acara
                                </h3>
                            </div>
                            <div class="modal-body">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label class="form-label">Tahun</label>
                                            <input type="text" value="{{ $date->trans_date }}"  readonly class="form-control form-control-solid rounded rounded-4">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label class="form-label">Nama Kab/Kota</label>
                                            <input type="text" value="{{ $zona->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="pembahas" class="form-label">Nama Penanggungjawab Kab/Kota</label>
                                            <input type="text" required class="form-control form-control-solid rounded rounded-4" id="pembahas" name="pembahas" placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="jabatan" class="form-label">Jabatan Penanggungjawab Kab/Kota</label>
                                            <input type="text"  required class="form-control form-control-solid rounded rounded-4" id="jabatan" name="jabatan" placeholder="Jabatan">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="operator" class="form-label">Tim Verifikasi Provinsi</label>
                                            <input type="text" required class="form-control form-control-solid rounded rounded-4" id="operator" name="operator" placeholder="Nama">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="tahun" value="{{ $date->id }}">
                                <input type="hidden" name="kota" value="{{ $zona->id}}">
                                <input type="hidden" name="idCategory" value="{{ $category->id}}">

                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-4">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border p-3" rowspan="2">No.</th>
                            <th class="w-150px text-center border-1 border align-middle p-3" rowspan="2">Pertanyaan</th>
                            <th class="w-200px text-center border-1 border align-middle" colspan="4">Self Assesment Kab/Kota</th>
                            <th class="w-200px text-center border-1 border align-middle" colspan="4">Provinsi</th>
                            {{-- <th class="w-100px text-center border-1 border align-middle" colspan="3">Pusat</th> --}}
                            <th class=" w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>

                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Angka</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                            <th class="text-center border-1 border align-middle p-3">Status Dokumen</th>


                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Angka</th>
                            <th class="text-center border-1 border align-middle p-3">Catatan Umum</th>
                            <th class="text-center border-1 border align-middle p-3">Catatan Detail</th>


                            {{-- <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->name }}</td>
                            @php
                                $relatedAnswer = $answer->where('id_question', $item->id)->first();

                                $requiredDocs = $item->_doc_question ?? collect();
                                $uploadedDocs = $uploadedFiles->where('id_question', $item->id);

                                // $requiredCount = $requiredDocs->count();
                                // $uploadedCount = $uploadedDocs->count();
                                $uploadedCount = 0;

                                foreach ($requiredDocs as $doc) {
                                    $matched = $uploadedDocs->firstWhere('id_doc_question', $doc->id); 
                                    if ($matched) {
                                        $uploadedCount++;
                                    }
                                }
                                $requiredCount = $requiredDocs->count();
                            @endphp

                            @if ($relatedAnswer)
                                <td class="border-1 border p-3">{{ $relatedAnswer->_q_option->name }}</td>
                                <td class="border-1 border text-center p-3">{{ $relatedAnswer->_q_option->score }}</td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-success">Sudah dijawab</div>
                                </td>
                                {{-- <td class="border-1 border text-center p-3">
                                    @if ($uploadedCount >= $requiredCount && $requiredCount > 0)
                                        <div class="badge badge-light-success">Semua dokumen diupload</div>
                                    @elseif ($uploadedCount > 0 && $uploadedCount < $requiredCount)
                                        <div class="badge badge-light-warning">Dokumen belum lengkap ({{$uploadedCount}} dari {{$requiredCount}})</div>
                                    @else
                                        <div class="badge badge-light-danger">Belum diupload</div>
                                    @endif
                                </td> --}}
                                <td class="border-1 border text-center p-3">
                                    @if ($requiredCount > 0)
                                        @if ($uploadedCount >= $requiredCount)
                                            <div class="badge badge-light-success">Semua dokumen diupload</div>
                                        @elseif ($uploadedCount > 0)
                                            <div class="badge badge-light-warning">
                                                Dokumen belum lengkap ({{ $uploadedCount }} dari {{ $requiredCount }})
                                            </div>
                                        @else
                                            <div class="badge badge-light-danger">Belum diupload</div>
                                        @endif
                                    @else
                                        <div class="badge badge-light-secondary">Tidak ada dokumen</div>
                                    @endif
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
                                <td class="border-1 border p-3">
                                    @if($relatedAnswer && $relatedAnswer->comment_detail_prov)
                                        {{ $relatedAnswer->comment_detail_prov }}
                                    @else
                                        <div class="badge badge-light-danger">-</div>
                                    @endif
                                </td>
                                {{-- <td class="border-1 border p-3">-</td> --}}

                                {{-- <td class="border-1 border p-3">{{ $relatedAnswer->_q_option_pusat->name?? '-' }}</td>
                                <td class="border-1 border text-center p-3">{{ $relatedAnswer->_q_option_pusat->score??'-'}}</td>
                                <td class="border-1 border p-3">
                                    @if($relatedAnswer && $relatedAnswer->comment_pusat)
                                        {{ $relatedAnswer->comment_pusat }}
                                    @else
                                        <div class="badge badge-light-danger">Belum dijawab</div>
                                    @endif
                                </td> --}}
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

                                {{-- <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td> --}}
                            @endif

                            <td>
                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        {{-- <i class="fas fa-pen-nib"></i> --}}
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                                <div class="modal modal-lg fade modal-dialog-scrollable" tabindex="-1" id="confirmUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">
                                                    Edit Verifikasi Pertanyaan
                                                </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('v-prov.store', ['id' => $item->id, 'id_zona' => $zona->id])}}" method="POST">
                                                @csrf
                                                <p>
                                                    <strong>Pertanyaan:</strong> 
                                                </p>
                                                <p>{{ $item->name }}</p> 
                                                <table class="table table-bordered mb-4 border">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-1 border">Opsi Jawaban</th>
                                                            <th class="w-25 border-1 border">Nilai Jawaban</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $sessionDate = session('selected_year');
                                                            $relatedAnswer = $answer->where('id_question', $item->id)->first();
                                                        @endphp
                                                        
                                                        @if ($relatedAnswer && $relatedAnswer->id_option_prov)
                                                            @foreach ($item->_q_option as $opsi)
                                                            @if ($opsi->id_survey == $sessionDate)
                                                                <tr>
                                                                    <td class="border-1 border">
                                                                        <div class="form-check">
                                                                            <input 
                                                                                class="form-check-input" 
                                                                                type="radio" 
                                                                                name="id_option_prov" 
                                                                                id="name_option_{{$opsi->id}}"
                                                                                value="{{ $opsi->id }}" 
                                                                                @if($relatedAnswer->id_option_prov == $opsi->id) checked @endif
                                                                                required
                                                                            >
                                                                            <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="border-1 border">
                                                                        <label class="form-check-label">{{ $opsi->score }}</label>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @endforeach
                                                        @else
                                                        
                                                            @foreach ($item->_q_option as $opsi)
                                                            @if ($opsi->id_survey == $sessionDate)
                                                                <tr>
                                                                    <td class="border-1 border">
                                                                        <div class="form-check">
                                                                            <input 
                                                                                class="form-check-input" 
                                                                                type="radio" 
                                                                                name="id_option_prov" 
                                                                                id="name_option_{{ $opsi->id }}" 
                                                                                value="{{ $opsi->id }}" 
                                                                                required
                                                                            >
                                                                            <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                        </div>

                                                                    </td>
                                                                    <td class="border-1 border">
                                                                        <label class="form-check-label">{{ $opsi->score }}</label>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @endforeach
                                                            
                                                        @endif
                                                        
                                                        

                                                    </tbody>
                                                </table>

                                                {{-- <div id="dynamic-input-pdf mb-4 ">
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
                                                    
                                                </div> --}}
                                                
                                                <div class="row">
                                                    <div class="col-6 mb-4">
                                                        <div class="form-group w-100">
                                                            <label for="achievement" class="form-label">Capaian {{$date->trans_date - 1}}</label>
                                                            {{-- @php
                                                                $datesV2 = $dates->where('trans_date',$date->trans_date - 1)->first();
                                                                if($datesV2){
                                                                    $questionByYear = \App\Models\M_Questions::where('id', $item->id)->first();
                                                                    $questionByYearV2 = \App\Models\M_Questions::where('name', $questionByYear->name)
                                                                        ->where('id_survey', $datesV2->id)->first();
                                                                    $answerV2 = \App\Models\Trans_Survey_D_Answer::where('id_question', $questionByYearV2->id)
                                                                        ->where('id_survey', $datesV2->id)->first();
                                                                }
                                                                else {
                                                                    $answerV2 = null;
                                                                }
                                                            @endphp --}}
                                                            @php
                                                                $datesV2 = $dates->where('trans_date', $date->trans_date - 1)->first();
                                                                if ($datesV2) {
                                                                    $questionByYear = \App\Models\M_Questions::where('id', $item->id)->first();

                                                                    if ($questionByYear) {
                                                                        $questionByYearV2 = \App\Models\M_Questions::where('name', $questionByYear->name)
                                                                            ->where('id_survey', $datesV2->id)->first();

                                                                        if ($questionByYearV2) {
                                                                            $answerV2 = \App\Models\Trans_Survey_D_Answer::where('id_question', $questionByYearV2->id)
                                                                                ->where('id_zona',$zona->id)
                                                                                ->where('id_survey', $datesV2->id)->first();
                                                                        } else {
                                                                            $answerV2 = null;
                                                                        }
                                                                    } else {
                                                                        $answerV2 = null;
                                                                    }
                                                                } else {
                                                                    $answerV2 = null;
                                                                }                                  
                                                            @endphp
                                                            <input type="number"
                                                                class="form-control form-control-solid rounded rounded-4"
                                                                placeholder="{{ $datesV2 ? ($answerV2 ? $answerV2->achievement : 'Belum diisi') : 'Tahun tidak tersedia' }}"
                                                                readonly
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <div class="form-group w-100">
                                                            <label for="achievement" class="form-label">Capaian {{$date->trans_date}}</label>
                                                            <input type="number"
                                                                id="achievement"
                                                                class="form-control form-control-solid rounded rounded-4"
                                                                placeholder="{{ $relatedAnswer ? ($relatedAnswer->achievement ?? 'Belum diisi') : 'Belum diisi' }}"
                                                                readonly
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <div class="form-group w-100">
                                                            <label for="comment" class="form-label">Penjelasan</label>
                                                            <textarea 
                                                                cols="2" rows="2" 
                                                                class="form-control-solid form-control rounded rounded-4"
                                                                required
                                                                readonly
                                                                placeholder="{{ $relatedAnswer ? ($relatedAnswer->comment ?? 'Belum diisi') : 'Belum diisi' }}"
                                                            ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($date->id == 5)
                                                <span>Data Dukung Tahun 2023</span>
                                                <table class="table mb-4 table-striped table-row-bordered border rounded">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-50 border border-1">Data Pendukung</th>
                                                            <th class="w-60px border border-1">Penjelasan</th>
                                                            <th class="border border-1">File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $question2023 = \App\Models\M_Questions::where('name', $item->name)
                                                                ->whereHas('_category', function ($q) {
                                                                    $q->where('id_survey', 7); // kategori tahun 2023
                                                                })->first();;
                                                            $docQuestions23 = $question2023 
                                                                ? \App\Models\Doc_Question::where('id_question', $question2023->id)->get()
                                                                : collect();
                                                        @endphp
                                                        @foreach ($docQuestions23 as $doc2)
                                                            <tr>
                                                                <td class="border border-1">{{$doc2->name}}</td>
                                                                <td class="border border-1 text-center">
                                                                    <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Keterangan" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$doc2->ket}}">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </button>
                                                                </td>
                                                                 @php
                                                                    $uploadedFile2 = \App\Models\Trans_Upload_KabKota::where('id_zona',$zona->id)
                                                                    ->where('id_survey', 7)
                                                                    ->where('id_doc_question', $doc2->id)
                                                                    ->first();
                                                                @endphp
                                                                 @if ($uploadedFile2 && $uploadedFile2->file_path)
                                                                    <td class="border border-1">
                                                                        <a href="{{ asset('uploads/doc_pendukung/'.$uploadedFile2->file_path) }}" target="_blank" class="btn btn-success btn-sm ">
                                                                            <div class="d-flex justify-content-center">
                                                                                Lihat
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td class="border border-1">
                                                                        <div class="badge badge-light-danger">Belum diupload</div>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endif

                                               
                                                <span>Data Dukung Tahun {{$date->trans_date}}</span>
                                                <table class="table mb-4 table-striped table-row-bordered border rounded">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-50 border border-1">Data Pendukung</th>
                                                            <th class="w-60px border border-1">Penjelasan</th>
                                                            <th class="border border-1">File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $docQuestions = \App\Models\Doc_Question::where('id_question', $item->id)->get();
                                                        @endphp
                                                        @foreach ($docQuestions as $doc)
                                                            <tr>
                                                                <td class="border border-1">{{$doc->name}}</td>
                                                                <td class="border border-1 text-center">
                                                                    <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Keterangan" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$doc->ket}}">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </button>
                                                                </td>
                                                                @php
                                                                    $uploadedFile = $uploadedFiles->where('id_doc_question', $doc->id)->first();
                                                                @endphp
                                                                @if ($uploadedFile && $uploadedFile->file_path)
                                                                    <td class="border border-1">
                                                                        <a href="{{ asset('uploads/doc_pendukung/'.$uploadedFile->file_path) }}" target="_blank" class="btn btn-success btn-sm ">
                                                                            <div class="d-flex justify-content-center">
                                                                                Lihat
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td class="border border-1">
                                                                        <div class="badge badge-light-danger">Belum diupload</div>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                @if ($relatedAnswer && $relatedAnswer->id_option_prov)
                                                    <div class="row mb-3 gap-3">
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="comment_prov" class="form-label">Catatan Umum Verifikasi<span class="required"></span></label>
                                                                <textarea name="comment_prov" required class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Umum">{{$relatedAnswer->comment_prov}}</textarea>
                                                                
                                                                @error('comment_prov')
                                                                    <div class="is-invalid">
                                                                        <span class="text-danger">
                                                                            {{$message}}
                                                                        </span>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="comment_detail_prov" class="form-label">Catatan Detail Verifikasi<span class="required"></span></label>
                                                                <textarea name="comment_detail_prov" required class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Detail">{{$relatedAnswer->comment_detail_prov}}</textarea>
                                                                
                                                                @error('comment_detail_prov')
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
                                                    <div class="row mb-3 gap-3">
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="name" class="form-label">Catatan Umum Verifikasi <span class="required"></span> </label>
                                                                <textarea required name="comment_prov" required class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Umum"></textarea>
                                                                
                                                                @error('comment_prov')
                                                                    <div class="is-invalid">
                                                                        <span class="text-danger">
                                                                            {{$message}}
                                                                        </span>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="comment_detail_prov" class="form-label">Catatan Detail Verifikasi<span class="required"></span></label>
                                                                <textarea name="comment_detail_prov" required class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Detail"></textarea>
                                                                
                                                                @error('comment_detail_prov')
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
                                                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                                <button type="submit" class="btn btn-primary rounded-4">Simpan</button>
                                            </div>
                                        </form>
                                        
                                        </div>
                                    </div>
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
