@extends('partials.index')
@section('heading')
    Dashboard {{$district->name}}
@endsection
@section('page')
    <a href="{{ route('home.index') }}" class="text-muted text-hover-primary">
        {{-- Data Kategori --}}
        Dashboard
    </a>
@endsection
@section('sub-page')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item">
        <span class="">
            <a href="{{ route('home.getDistrict',$district->id) }}" class="text-muted text-hover-primary">
                {{$district->name}}
            </a>
        </span>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-muted">
        <span class="text-gray">
            {{$category->name}}
        </span>
    </li>
@endsection

@section('content')
    @php
        $totalQuestion = $questions->count();
        $answerSuccess = $answer->where('id_category', $category->id)->count();

        $maxScrore = $totalQuestion*100;
        $yourScore = \DB::table('trans_survey_d_answer')
            ->join('m_question_options', 'trans_survey_d_answer.id_option', '=', 'm_question_options.id')
            ->where('trans_survey_d_answer.id_category', $category->id)
            ->where('trans_survey_d_answer.id_zona', $district->id)
            ->where('trans_survey_d_answer.id_survey', $session_date)
            ->sum('m_question_options.score');
    @endphp

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
                            <th class="text-center border-1 border align-middle" colspan="4">Self Assesment Kab/Kota</th>
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

                                <td>-</td>
                                
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
   </script>
    
        
@endsection
