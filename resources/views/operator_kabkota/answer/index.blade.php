@extends('partials.index')
@section('heading')
    Pertanyaan
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
                    ->where('trans_survey_d_answer.id_zona', $idZona)
                    ->where('trans_survey_d_answer.id_survey', $session_date)
                    ->sum('m_question_options.score');
        $now = strtotime(now());
        // echo($now);
        $start = strtotime($schedule->started_at);
        $end = strtotime($schedule->ended_at);
    @endphp
    
    <div class="card mb-5 p-7 bg-card-stopwatch text-custom-primary rounded rounded-4">
        <div class="row align-items-center">
            <div class="col-lg-6 ">
                <h3 class="text-custom-primary fw-bolder">{{$schedule->notes}}</h3>
                <h3 class="text-custom-primary fw-bolder">Jadwal dimulai tanggal {{$schedule->started_at->format('d-m-Y')}} jam {{$schedule->started_at->format('H:i')}}</h3>
                <h3 class="text-custom-primary fw-bolder">Jadwal berakhir tanggal {{$schedule->ended_at->format('d-m-Y')}} jam {{$schedule->ended_at->format('H:i')}}</h3>
            </div>
            <div class="col-lg-6 text-end">
                <img src="{{asset('assets/img/stopwatch.png')}}" class="w-80px" alt="">
                <span id="time-range" class="fw-bolder"></span>
            </div>
        </div>
    </div>
    
    <div class="row mb-3 justify-content-center">
        <div class="col-lg-6 d-flex justify-content-center mb-4">
            <div class="card rounded rounded-4 shadow-sm w-100">
                <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-6">
                            <h4 class="pb-5">Pertanyaan</h4>
                            <div class="row">
                                <div class="col-8">
                                    <h5>
                                        Jumlah pertanyaan
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <h5>
                                        : {{$totalQuestion}}
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <h5>
                                        Dijawab
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <h5>
                                        : {{$answerSuccess}}
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <h5>
                                        Belum dijawab
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <h5>
                                        : {{$totalQuestion - $answerSuccess}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <canvas id="questionChart" class="w-md-100 w-sm-50 h-md-100 h-sm-50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex justify-content-center mb-4">
            <div class="card rounded rounded-4 shadow-sm w-100" >
                <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-6">
                            <h4 class="pb-5">Nilai Assesment</h4>
                            <div class="row">
                                <div class="col-sm-8 col-6">
                                    <h5>
                                        Nilai Maksimal
                                    </h5>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <h5>
                                        : {{$maxScrore}}
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-6">
                                    <h5>
                                        Nilai saat ini
                                    </h5>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <h5>
                                        : {{$yourScore}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <canvas id="scoreChart" class="w-md-100 w-sm-50 h-md-100 h-sm-50"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4">
            <div class="card rounded rounded-4">
                <div class="card-body">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Tatanan {{$category->name}}</h3>
                
            </div>
        </div>
        <div class="card-body">
          
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border p-3" rowspan="2">No.</th>
                            <th class="w-50px text-center border-1 border align-middle p-3" rowspan="2">Pertanyaan</th>
                            <th class="text-center border-1 border align-middle" colspan="4">Self Assesment</th>
                            <th class="text-center border-1 border align-middle" colspan="3">Provinsi</th>
                            <th class="text-center border-1 border align-middle" colspan="3">Pusat</th>
                            <th class=" w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>

                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                            <th class="text-center border-1 border align-middle p-3">Dokumen</th>

                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>

                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td class="border-1 border text-center p-3">{{ $loop->iteration }}</td>
                                <td class="border-1 border p-3">{{ $question->name }}</td>
                                @php
                                    $relatedAnswer = $answer->where('id_question', $question->id)->first(); // This will return a single instance or null
                                    $uploadedFile = $uploadedFiles->where('id_question', $question->id);
                                @endphp
                                @if($relatedAnswer)
                                    <td class="border-1 border p-3">{{ $relatedAnswer->_q_option->name }}</td>
                                    <td class="border-1 border text-center p-3">{{ $relatedAnswer->_q_option->score }}</td>
                                    <td class="border-1 border text-center p-3">
                                        <div class="badge badge-light-success">Sudah dijawab</div>
                                    </td>
                                    @if ($uploadedFile->isNotEmpty())
                                        <td class="border-1 border text-center p-3">
                                            <div class="badge badge-light-success">Sudah diupload</div>
                                        </td>
                                    @else
                                        <td class="border-1 border text-center p-3">
                                            <div class="badge badge-light-danger">Belum diupload</div>
                                        </td>
                                    @endif
                                    

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
                                    <td class="border-1 border p-3">-</td>
                                @endif

                                <td class="border-1 border p-3 text-center">
                                    <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $question->id }}">
                                        <div class="d-flex justify-content-center">
                                            {{-- <i class="fas fa-pen-nib"></i> --}}
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </button>
                                    <div class="modal modal-lg fade text-start" tabindex="-1" id="confirmUpdate{{ $question->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Edit Jawaban
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('answer-data.store', $question->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <p>
                                                        <strong>Pertanyaan:</strong> 
                                                        <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Data Operasional" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$question->d_operational}}">
                                                            <i class="fa fa-info-circle"></i>
                                                        </button>
                                                        
                                                    </p>
                                                    <p>{{$question->name}}</p>
                                                    <input name="id_survey" value="{{session('selected_year')}}" hidden>
                                                    <table class="table mb-3 table-striped table-row-bordered border rounded mb-3">
                                                        <thead>
                                                            <tr>
                                                                <th class="border border-1">Opsi Jawaban</th>
                                                                <th class="w-25 border border-1">Nilai Jawaban</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $sessionDate = session('selected_year');
                                                                $relatedAnswer = $answer->where('id_question', $question->id)->first();
                                                            @endphp
                                                            @if($relatedAnswer)
                                                                @foreach ($question->_q_option as $opsi)
                                                                    @if ($opsi->id_survey == $sessionDate)
                                                                        <tr>
                                                                            <td class="border border-1">
                                                                                <div class="form-check">
                                                                                    <input 
                                                                                        class="form-check-input" 
                                                                                        type="radio" 
                                                                                        name="id_option" 
                                                                                        id="name_option_{{$opsi->id}}"
                                                                                        value="{{ $opsi->id }}" 
                                                                                        @if($relatedAnswer->id_option == $opsi->id) checked @endif
                                                                                        @if ($now >= $start && $now <= $end) 
                                                                                            required 
                                                                                        @else 
                                                                                            disabled 
                                                                                        @endif
                                                                                        
                                                                                    >
                                                                                    <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                                </div>
                                                                            </td>
                                                                            <td class="border border-1">
                                                                                <span>{{ $opsi->score }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    
                                                                @endforeach
                                                            @else
                                                                @foreach ($question->_q_option as $opsi)
                                                                    @if ($opsi->id_survey == $sessionDate)
                                                                        <tr>
                                                                            <td class="border border-1">
                                                                                <div class="form-check form-check-custom form-check-solid">
                                                                                    <input 
                                                                                        class="form-check-input" 
                                                                                        type="radio" 
                                                                                        name="id_option" 
                                                                                        value="{{ $opsi->id }}" 
                                                                                        id="name_option_{{ $opsi->id }}" 
                                                                                        @if ($now >= $start && $now <= $end) 
                                                                                            required 
                                                                                        @else 
                                                                                            disabled 
                                                                                        @endif
                                                                                    >
                                                                                    <label class="form-check-label" for="name_option_{{ $opsi->id }}">{{ $opsi->name }}</label>
                                                                                </div>

                                                                            </td>
                                                                            <td class="border border-1">
                                                                                <span>{{ $opsi->score }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    
                                                    <div class="row">
                                                        <div class="col-6 mb-4">
                                                            <div class="form-group w-100">
                                                                <label for="achievement" class="form-label">Capaian {{$date->trans_date - 1}}</label>
                                                                @php
                                                                    $datesV2 = $dates->where('trans_date',$date->trans_date - 1)->first();
                                                                    if ($datesV2) {
                                                                        $questionByYear = \App\Models\M_Questions::where('id', $question->id)->first();
                                                                        $questionByYearV2 = \App\Models\M_Questions::where('name', $questionByYear->name)
                                                                            ->where('id_survey', $datesV2->id)->first();
                                                                        $answerV2 = \App\Models\Trans_Survey_D_Answer::where('id_question', $questionByYearV2->id)
                                                                            ->where('id_zona', $idZona)
                                                                            ->where('id_survey', $datesV2->id)->first();
                                                                    }
                                                                    else {
                                                                        $answerV2 = null;
                                                                    }
                                                                    
                                                                @endphp
                                                                <input type="number"
                                                                    class="form-control form-control-solid rounded rounded-4"
                                                                    {{-- {{$questionByYear ? $questionByYear->name : 'o'}} --}}
                                                                    placeholder="{{ $datesV2 ? ($answerV2 ? $answerV2->achievement : 'Belum diisi') : 'Tahun tidak tersedia' }}"

                                                                    {{-- placeholder="{{$datesV2 ? $datesV2->trans_date : 'Tidak ada'}}" --}}
                                                                    oninvalid="this.setCustomValidity('Capaian tidak boleh kosong.')"
                                                                    oninput="this.setCustomValidity('')"
                                                                    step="0.01"
                                                                    min="0"
                                                                    readonly
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <div class="form-group w-100">
                                                                <label for="achievement" class="form-label">Capaian {{$date->trans_date}}</label>
                                                                <input type="number"
                                                                    id="achievement"
                                                                    name="achievement"
                                                                    class="form-control form-control-solid rounded rounded-4"
                                                                    placeholder="0.00"
                                                                    oninvalid="this.setCustomValidity('Capaian tidak boleh kosong.')"
                                                                    oninput="this.setCustomValidity('')"
                                                                    step="0.01"
                                                                    min="0"
                                                                    required
                                                                    onchange="validateDecimal(this)"
                                                                    @if ($relatedAnswer)
                                                                        value="{{$relatedAnswer->achievement}}"
                                                                    @endif
                                                                >
                                                                @error('achievement')
                                                                    <div class="is-invalid">
                                                                        <span class="text-danger">
                                                                            {{$message}}
                                                                        </span>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <div class="form-group w-100">
                                                                <label for="comment" class="form-label">Penjelasan</label>
                                                                <textarea 
                                                                    name="comment" 
                                                                    id="comment" 
                                                                    cols="2" rows="2" 
                                                                    placeholder="Penjelasan" 
                                                                    class="form-control-solid form-control rounded rounded-4"
                                                                    required
                                                                >@if($relatedAnswer){{$relatedAnswer->comment}}@endif</textarea>
                                                                @error('comment')
                                                                    <div class="is-invalid">
                                                                        <span class="text-danger">
                                                                            {{$message}}
                                                                        </span>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-2">
                                                        <span class="required">Data Dukung berupa Pdf dan maksimal 2 MB</span>
                                                    </div>
                                                    
                                                    <table class="table mb-3 table-striped table-row-bordered border rounded">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-50 border border-1">Data Pendukung</th>
                                                                <th class="w-60px border border-1">Penjelasan</th>
                                                                <th class="border border-1">File</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $sessionDate = session('selected_year');
                                                                $relatedAnswer = $answer->where('id_question', $question->id)->first();
                                                            @endphp
                                                            @if($relatedAnswer)
                                                                @foreach ($question->_doc_question as $opsi)
                                                                    @if ($opsi->id_survey == $sessionDate)
                                                                        @php
                                                                            $uploadedFile = $uploadedFiles->where('id_doc_question', $opsi->id)->first();
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="border border-1">
                                                                                {{$opsi->name}}
                                                                            </td>
                                                                            <td class="border border-1 text-center">
                                                                                <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Keterangan" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$opsi->ket}}">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </button>
                                                                            </td>
                                                                            <td class="border border-1">
                                                                                @if (!$uploadedFile)
                                                                                    <!-- No file uploaded: Show input field -->
                                                                                    <input type="file" name="file_{{$opsi->id}}" class="form-control">
                                                                                @else
                                                                                    <a href="{{ asset('uploads/doc_pendukung/'.$uploadedFile->file_path) }}" target="_blank" class="btn btn-success btn-sm ">
                                                                                        <div class="d-flex justify-content-center">
                                                                                            Lihat
                                                                                        </div>
                                                                                    </a>
                                                                                    <button 
                                                                                        @if ($now >= $start && $now <= $end)
                                                                                            type="submit" 
                                                                                            class="btn btn-danger btn-sm delete-btn" data-id="{{ $uploadedFile->id }}"
                                                                                        @else
                                                                                            class="btn btn-danger btn-sm" disabled
                                                                                        @endif>
                                                                                        Hapus
                                                                                    </button>
                                                                                    <div class="col-md-2">
                                                                                        
                                                                                    </div>
                                                                                    
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach ($question->_doc_question as $opsi)
                                                                    @if ($opsi->id_survey == $sessionDate)
                                                                        @php
                                                                            $uploadedFile = $uploadedFiles->where('id_doc_question', $opsi->id)->first();
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="border border-1">
                                                                                {{$opsi->name}}
                                                                            </td>
                                                                            <td class="border border-1">
                                                                                <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Keterangan" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$opsi->ket}}">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </button>
                                                                            </td>
                                                                            <td class="border border-1">
                                                                                @if (!$uploadedFile)
                                                                                    <input type="file" name="file_{{$opsi->id}}" class="form-control">
                                                                                @else
                                                                                    <a href="{{ url('path_to_uploaded_file/' . $uploadedFile->filename) }}" target="_blank" class="btn btn-sm btn-icon btn-primary">
                                                                                        <i class="fas fa-eye"></i> View
                                                                                    </a>
                                                                                    <input type="file" name="file_{{$opsi->id}}" class="form-control">
                                                                                    <input type="hidden" name="file_id_{{$opsi->id}}" value="{{$uploadedFile->id}}">
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()" >Batal</button>
                                                    &nbsp;
                                                    <button 
                                                    @if ($now >= $start && $now <= $end)
                                                        type="submit" 
                                                        class="btn btn-primary rounded-4 hover-scale"
                                                    @else
                                                        class="btn btn-primary rounded-4 hover-scale" disabled
                                                    @endif>
                                                        Simpan
                                                    </button>
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
        function validateDecimal(input) {
            // Ganti koma dengan titik
            // console.log('hello');
            
            input.value = input.value.replace(',', '.');
            console.log(input.value);
            

            // if (input.value && !/^\d+(\.\d{0,2})?$/.test(input.value)) {
            //     alert('Masukkan angka desimal yang valid (maksimal 2 desimal).');
            //     input.value = ''; // Mengosongkan input jika tidak valid
            //     input.focus(); // Mengembalikan fokus ke input
            // }
        }

        $(document).ready(function() {
            var counter = 1;
            $(document).on('click', '#add-field', function() {
                counter++;
                var modalBody = $(this).closest('.modal-body'); // Get the current modal's body

                var newField = $(`
                    <div class="row d-flex align-items-center mb-3" id="field-${counter}">
                        <div class="col-md-5">
                            <input type="text" name="nama_data[]" class="form-control form-control-solid rounded rounded-4" placeholder="Nama Data" required>
                        </div>
                        <div class="col-md-5">
                            <input type="file" name="file_path[]" class="form-control form-control-solid rounded rounded-4" placeholder="Score" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteField(${counter})">Hapus</button>
                        </div>
                    </div>
                `);
                modalBody.find('#dynamic-input-pdf').append(newField);
                
            });
            
            
            
        });
        
       

        function deleteField(id) {
            $(`#field-${id}`).remove();
            event.stopPropagation();
        }

        $(document).ready(function() {
            $('input[name="replace_file[]"]').on('change', function() {
                var fileId = $(this).val();
                if ($(this).is(':checked')) {
                    $('#replaceFileInput' + fileId).show();
                    $('#replaceNamaData' + fileId).show(); // Tampilkan input file baru
                } else {
                    $('#replaceFileInput' + fileId).hide();
                    $('#replaceNamaData' + fileId).hide(); // Sembunyikan input file baru
                }
            });
        });


        const totalQuestion = {{ $totalQuestion }};
        const answeredQuestions = {{ $answerSuccess }};
        const unansweredQuestions = {{$totalQuestion - $answerSuccess}};

        const maxScore = {{ $maxScrore }};
        const yourScore = {{ $yourScore }};

        const ctx = document.getElementById('questionChart').getContext('2d');
        const questionChart = new Chart(ctx, {
            type: 'pie', 
            data: {
                labels: ['Sudah Dijawab', 'Belum Dijawab'],
                datasets: [{
                    label: 'Jumlah Pertanyaan',
                    data: [answeredQuestions, unansweredQuestions],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Color for answered
                        'rgba(255, 99, 132, 0.6)'  // Color for unanswered
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: 'Status Pertanyaan'
                    }
                }
            }
        });

        const ctx2 = document.getElementById('scoreChart').getContext('2d');
        const scoreChart = new Chart(ctx2, {
            type: 'pie', 
            data: {
                labels: ['Score Kab/kota', 'Score Max',],
                datasets: [{
                    label: 'Jumlah Pertanyaan',
                    data: [yourScore, maxScore],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Color for answered
                        'rgba(255, 99, 132, 0.6)'  // Color for unanswered
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: 'Nilai'
                    }
                }
            }
        });

        
        $(document).on('click', '.delete-btn', function () {
            var deleteFileId = $(this).data('id');
            // $('#confirmDeleteModal').modal('show');
            var url = '/kabkota/answer-data/destroydoc/' + deleteFileId;

            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        text: "File berhasil dihapus!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    // alert('File berhasil dihapus!');
                },
                error: function (xhr) {
                    Swal.fire({
                        text: "Gagal menghapus file. Silakan coba lagi.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    // alert('Gagal menghapus file. Silakan coba lagi.');
                }
            });

        });

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
        
        var startTime = @json($start);
        var endTime = @json($end);
        var now = Math.floor(Date.now() / 1000); // Waktu saat ini dalam detik

        // Fungsi untuk menghitung dan menampilkan waktu tersisa
        function updateTime() {
            now = Math.floor(Date.now() / 1000); // Update waktu saat ini

            if (now < startTime) {
                // Jika waktu sekarang sebelum waktu mulai
                var timeDiff = startTime - now;
                document.getElementById("time-range").innerHTML = "Waktu mulai: " + formatTime(timeDiff);
            } else if (now >= startTime && now <= endTime) {
                // Jika waktu sekarang dalam rentang waktu
                var timeDiff = endTime - now;
                document.getElementById("time-range").innerHTML = "Waktu tersisa: " + formatTime(timeDiff);
            } else {
                // Jika waktu sekarang setelah waktu selesai
                document.getElementById("time-range").innerHTML = "Waktu sudah berakhir.";
            }
        }

        // Fungsi untuk memformat waktu dalam format jam:menit:detik
        function formatTime(seconds) {
            var months = Math.floor(seconds / (3600 * 24 * 30)); // Menghitung bulan
            var days = Math.floor((seconds % (3600 * 24 * 30)) / (3600 * 24)); // Menghitung hari
            var hours = Math.floor((seconds % (3600 * 24)) / 3600); // Menghitung jam
            var minutes = Math.floor((seconds % 3600) / 60); // Menghitung menit
            var secs = seconds % 60; // Menghitung detik
            return months + " bulan " + days + " hari " + hours + " jam " + minutes + " menit " + secs + " detik";
            // return hours + " : " + minutes + " : " + seconds
            // return hours + " jam " + minutes + " menit " + secs + " detik";
        }

        // Panggil fungsi updateTime setiap detik
        setInterval(updateTime, 1000);

        // Panggil fungsi sekali untuk menampilkan waktu saat halaman dimuat
        updateTime();
        
    </script>
@endsection
