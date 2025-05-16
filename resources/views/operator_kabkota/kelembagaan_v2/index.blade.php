@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection


@section('content')
   @php
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
   
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>{{$category->name}}</h3>
                
            </div>
        </div>
        <div class="card-body">
          
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border p-3" rowspan="2">No.</th>
                            <th class="w-50px text-center border-1 border align-middle p-3" rowspan="2">Pertanyaan</th>
                            <th class="text-center border-1 border align-middle" colspan="5">Self Assesment</th>
                            <th class="text-center border-1 border align-middle" colspan="4">Provinsi</th>
                            {{-- <th class="text-center border-1 border align-middle" colspan="3">Pusat</th> --}}
                            <th class=" w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>

                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                            <th class="text-center border-1 border align-middle p-3">Dokumen</th>
                            <th class="text-center border-1 border align-middle p-3">Status Verifikasi</th>


                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Catatan Umum</th>
                            <th class="text-center border-1 border align-middle p-3">Catatan Detail</th>

                            {{-- <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($q_kelembagaan as $question)
                            <tr>
                                <td class="border-1 border text-center p-3">{{ $loop->iteration }}</td>
                                <td class="border-1 border p-3">{{ $question->indikator }}</td>
                                @php
                                    $relatedAnswer = $answer->where('id_q_kelembagaan', $question->id)->first(); // This will return a single instance or null
                                    $uploadedFile = $uploadedFiles->where('id_q_kelembagaan', $question->id);
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
                                    <td class="border-1 border p-3 text-center">
                                        @if ($relatedAnswer->status_verifikasi == 1)
                                            <div class="badge badge-light-danger">Belum diperbaiki</div>
                                        @elseif ($relatedAnswer->status_verifikasi == 2)
                                            <div class="badge badge-light-success">Sudah diperbaiki</div>
                                        @else
                                            <div class="badge badge-light-secondary">-</div>
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
                                    <td></td>


                                    <td class="border-1 border p-3">-</td>
                                    <td class="border-1 border p-3">-</td>
                                    <td class="border-1 border p-3">-</td>
                                    <td class="border-1 border p-3">-</td>

                                    {{-- <td class="border-1 border p-3">-</td>
                                    <td class="border-1 border p-3">-</td>
                                    <td class="border-1 border p-3">-</td> --}}
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
                                                        <form action="{{ route('kelembagaan-v2.store', $question->id)}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <p>
                                                                <strong>Pertanyaan:</strong> 
                                                                <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Data Operasional" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$question->d_operational}}">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </button>
                                                            </p>
                                                            <p>{{$question->indikator}}</p>
                                                            <input name="id_survey" value="{{session('selected_year')}}" hidden>
                                                            <table class="table mb-3 table-striped table-row-bordered border rounded mb-3">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="w-50 border border-1">Opsi Jawaban</th>
                                                                        <th class="border border-1">Nilai Jawaban</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $sessionDate = session('selected_year');
                                                                        $relatedAnswer = $answer->where('id_q_kelembagaan', $question->id)->first();
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
                                                                                                @if($relatedAnswer->id_opt_kelembagaan == $opsi->id) checked @endif
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
                                                                                        <label class="form-check-label">{{ $opsi->score }}</label>
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
                                                                                                @if ($now >= $start && $now <= $end) 
                                                                                                    required 
                                                                                                @else 
                                                                                                    disabled 
                                                                                                @endif
                                                                                                id="name_option_{{$opsi->id}}"
                                                                                            >
                                                                                            <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                                        </div>

                                                                                    </td>
                                                                                    <td class="border border-1">
                                                                                        <label class="form-check-label" >{{ $opsi->score }}</label>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                           
                                                            <div class="row mb-2">
                                                                
                                                                @if ($category && $category->is_status == 0 || $category->is_status == 1)
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="achievement1" class="form-label">Capaian {{$date->trans_date}}<span class="required"></span></label>
                                                                            <input type="text"
                                                                                name="achievement"
                                                                                id="achievement1"
                                                                                class="form-control form-control-solid rounded rounded-4"
                                                                                oninvalid="this.setCustomValidity('Capaian tidak boleh kosong.')"
                                                                                oninput="this.setCustomValidity('')"
                                                                                required
                                                                                placeholder="Capaian"
                                                                                @if ($relatedAnswer)
                                                                                    value="{{$relatedAnswer->achievement}}"
                                                                                @endif
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="notes1" class="form-label">Penjelasan <span class="required"></span></label>
                                                                            <textarea 
                                                                                name="note" 
                                                                                id="notes1" cols="3" rows="3" 
                                                                                class="form-control form-control-solid" placeholder="Penjelasan"
                                                                                required
                                                                            >@if ($relatedAnswer){{$relatedAnswer->note}}@endif</textarea>
                                                                        </div>
                                                                    </div>
                                                                @elseif($category && $category->is_status == 2)
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="sum_subdistrict" class="form-label">Jumlah Kecamatan </label>
                                                                            <input type="text"
                                                                                name="sum_subdistrict"
                                                                                id="sum_subdistrict"
                                                                                class="form-control form-control-solid rounded rounded-4"
                                                                                oninvalid="this.setCustomValidity('Kecamatan tidak boleh kosong.')"
                                                                                oninput="this.setCustomValidity('')"
                                                                                required
                                                                                placeholder="Kecamatan"
                                                                                value="{{$sum_subdistrict}}"
                                                                                readonly
                                                                                @if ($relatedAnswer)
                                                                                    value="{{$relatedAnswer->sum_subdistrict}}"
                                                                                @endif
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="achievement2" class="form-label">Capaian {{$date->trans_date}}<span class="required"></span></label>
                                                                            <input type="number"
                                                                                name="achievement"
                                                                                id="achievement2"
                                                                                class="form-control form-control-solid rounded rounded-4"
                                                                                oninvalid="this.setCustomValidity('Capaian tidak boleh kosong dan maksimal {{$sum_subdistrict}}.')"
                                                                                oninput="this.setCustomValidity('')"
                                                                                required
                                                                                placeholder="Capaian"
                                                                                max="{{$sum_subdistrict}}"
                                                                                @if ($relatedAnswer)
                                                                                    value="{{$relatedAnswer->achievement}}"
                                                                                @endif
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="notes2" class="form-label">Penjelasan <span class="required"></span></label>
                                                                            <textarea 
                                                                                name="note" 
                                                                                id="notes2" cols="3" rows="3" 
                                                                                class="form-control form-control-solid" placeholder="Penjelasan"
                                                                                required
                                                                            >@if ($relatedAnswer){{$relatedAnswer->note}}@endif</textarea>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="sum_village" class="form-label">Jumlah Kelurahan </label>
                                                                            <input type="text"
                                                                                name="sum_village"
                                                                                id="sum_village"
                                                                                class="form-control form-control-solid rounded rounded-4"
                                                                                oninvalid="this.setCustomValidity('Kelurahan tidak boleh kosong.')"
                                                                                oninput="this.setCustomValidity('')"
                                                                                required
                                                                                placeholder="Kelurahan"
                                                                                readonly
                                                                                value="{{$sum_village}}"
                                                                                @if ($relatedAnswer)
                                                                                    value="{{$relatedAnswer->sum_village}}"
                                                                                @endif
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="achievement3" class="form-label">Capaian {{$date->trans_date}} <span class="required"></span></label>
                                                                            <input type="number"
                                                                                name="achievement"
                                                                                id="achievement3"
                                                                                class="form-control form-control-solid rounded rounded-4"
                                                                                oninvalid="this.setCustomValidity('Capaian tidak boleh kosong dan maksimal {{$sum_village}}.')"
                                                                                oninput="this.setCustomValidity('')"
                                                                                required
                                                                                placeholder="Capaian"
                                                                                max="{{$sum_village}}"
                                                                                @if ($relatedAnswer)
                                                                                    value="{{$relatedAnswer->achievement}}"
                                                                                @endif
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group w-100">
                                                                            <label for="notes3" class="form-label">Penjelasan <span class="required"></span></label>
                                                                            <textarea 
                                                                                name="note" 
                                                                                id="notes3" cols="3" rows="3" 
                                                                                class="form-control form-control-solid" placeholder="Penjelasan"
                                                                                required
                                                                            >@if ($relatedAnswer){{$relatedAnswer->note}}@endif</textarea>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            @if ($date->id == 5)
                                                                <span class="mb-2">Data Dukung Tahun 2023</span>
                                                                <table class="table mb-4 table-striped table-row-bordered border rounded">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="w-50 border border-1">Data Pendukung</th>
                                                                            <th class="border border-1">File</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $category1 = \App\Models\M_C_Kelembagaan_New::where('id', $question->id_c_kelembagaan_v2)
                                                                                ->first();
                                                                            
                                                                            $category2 = \App\Models\M_C_Kelembagaan_New::where('id_survey', 7)
                                                                                ->where('name',$category1->name)
                                                                                ->first();
                                                                            $question2023 = \App\Models\M_Q_Kelembagaan_New::where('indikator', $question->indikator)
                                                                                ->where('id_c_kelembagaan_v2', $category2->id)
                                                                                ->first()
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="border border-1">
                                                                                {{ $question2023->data_dukung }}
                                                                            </td>
                                                                            @php
                                                                                $uploadedFile2 = \App\Models\Trans_Doc_Kelembagaan::where('id_zona',$idZona)
                                                                                ->where('id_survey', 7)
                                                                                ->where('id_q_kelembagaan', $question2023->id)
                                                                                ->first();
                                                                            @endphp
                                                                            @if ($uploadedFile2 && $uploadedFile2->path)
                                                                                <td class="border border-1">
                                                                                    <a href="{{ asset('uploads/doc_kelembagaan/'.$uploadedFile2->path) }}" target="_blank" class="btn btn-success btn-sm ">
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
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            @endif

                                                            <div class="mb-2">
                                                                <span>Data Dukung Tahun {{$date->trans_date}} Pdf dan maksimal 8 MB</span>
                                                                {{-- <span class="required">Data Dukung berupa Pdf dan maksimal 8 MB</span> --}}
                                                            </div>
                                                            <table class="table mb-3 table-striped table-row-bordered border rounded">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="w-50 border border-1">Data Pendukung</th>
                                                                        <th class="border border-1">File</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="border border-1">
                                                                            {{$question->data_dukung}}
                                                                        </td>

                                                                        @php
                                                                            $uploadedFile = $uploadedFiles->where('id_q_kelembagaan', $question->id)->first();
                                                                        @endphp
                                                                        <td class="border border-1">
                                                                            @if (!$uploadedFile)
                                                                                <input type="file" name="file_path" class="form-control" accept=".pdf">
                                                                            @else
                                                                                <a href="{{ asset('/uploads/doc_kelembagaan/'.$uploadedFile->path) }}" target="_blank" class="btn btn-success btn-sm ">
                                                                                    <div class="d-flex justify-content-center">
                                                                                        Lihat
                                                                                    </div>
                                                                                </a>
                                                                                <button 
                                                                                    @if ($now >= $start && $now <= $end)
                                                                                        type="submit" class="btn btn-danger btn-sm delete-btn" data-id="{{ $uploadedFile->id }}"
                                                                                    @else
                                                                                        class="btn btn-danger btn-sm" disabled
                                                                                    @endif
                                                                                >
                                                                                    Hapus
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                </tbody>
                                                            </table>

                                                            @if($relatedAnswer && !is_null($relatedAnswer->id_opt_kelembagaan_prov))
                                                            <div class="row mb-3 gap-3">
                                                                <div class="col-12">
                                                                    <div class="form-group w-100">
                                                                        <label for="comment_prov" class="form-label">Catatan Umum Verifikasi</label>
                                                                        <textarea name="comment_prov" readonly class="form-control form-control-solid rounded rounded-4" cols="3" rows="3">{{$relatedAnswer->comment_prov}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group w-100">
                                                                        <label for="comment_detail_prov" class="form-label">Catatan Detail Verifikasi</label>
                                                                        <textarea name="comment_detail_prov" readonly class="form-control form-control-solid rounded rounded-4" cols="3" rows="3">{{$relatedAnswer->comment_detail_prov}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                     <div class="form-group w-100">
                                                                    <label for="status_verifikasi" class="form-label">Status<span class="required"></span></label>
                                                                    <select 
                                                                        name="status_verifikasi" 
                                                                        aria-label="Default select example"
                                                                        class="form-select form-select-solid rounded rounded-4" 
                                                                        required
                                                                        autocomplete="off"
                                                                    >
                                                                    <option value="" disabled {{ is_null($relatedAnswer->status_verifikasi) ? 'selected' : '' }}>Pilih</option>
                                                                    <option value="1" {{ $relatedAnswer->status_verifikasi == 1 ? 'selected' : '' }}>Belum diperbaiki</option>
                                                                    <option value="2" {{ $relatedAnswer->status_verifikasi == 2 ? 'selected' : '' }}>Sudah diperbaiki</option>
                                                                    {{-- <option value="" disabled selected>Pilih</option>
                                                                    <option value="1">Belum diperbaiki</option>
                                                                    <option value="2">Sudah diperbaiki</option> --}}
                                                                
                                                                </select>
                                                                
                                                            </div>
                                                                </div>
                                                            </div>
                                                           
                                                            @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
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

    

    @php
        $c_v2 = $category;
    @endphp

    {{-- forum kec --}}
    
    @if ($category && $category->is_status == 2)
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3>SK Forum Komunikasi Kecamatan Sehat</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableForumKec" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-w-60px text-center border-1 border">No.</th>
                            <th class="min-w-60px text-center border-1 border">ID</th>
                            <th class="min-w-100px text-center border-1 border"></th>
                            <th class="min-w-200px border-1 border">Nama Kecamatan</th>
                            <th class="min-w-200px border-1 border">Forum Kecamatan</th>
                            <th class="min-w-200px border-1 border">No. SK</th>
                            <th class="min-w-200px border-1 border">Masa Berlaku SK</th>
                            <th class="min-w-200px border-1 border">Alokasi Anggaran Forum</th>
                            <th class="min-w-200px border-1 border">Alamat Sekretariat Forum</th>

                            <th class="min-w-150px border-1 border text-center">Dokumen SK Forum</th>
                            <th class="min-w-150px border-1 border text-center">Dokumen Renja Forum</th>
                            <th class="min-w-150px border-1 border text-center">Dokumen Anggaran</th>
                            <th class="min-w-150px border-1 border text-center">Foto Sekretariat</th>

                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($subdistrict as $item)
                           <tr>
                                @php
                                    $forum2 = $forumKec->where('id_subdistrict', $item->id)->first();
                                @endphp
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="border-1 border text-center">{{ $item->id }}</td>
                                <td class="border border-1 text-center">
                                    @if (is_null($forum2))
                                        <a href="{{ route('kelembagaan-v2.createForumKec', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('kelembagaan-v2.editForumKec', $item->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                        <button 
                                            @if ($now >= $start && $now <= $end)
                                                class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteSK{{ $forum2->id }}"
                                            @else
                                                class="btn btn-icon btn-danger w-35px h-35px mb-3" disabled
                                            @endif>
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-trash"></i>
                                            </div>
                                        </button>
                                    @endif
                                   
                                </td>
                                @if (!is_null($forum2))
                                    <div class="modal text-start fade" tabindex="-1" id="confirmDeleteSK{{ $forum2->id }}">
                                        <form action="{{ route('kelembagaan-v2.destroyForumKec', $forum2->id) }}" method="POST">
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
                                @endif
                                <td class="border-1 border">{{$item->name}}</td>
                                @if ($forum2)
                                    <td class="border-1 border">{{$forum2->f_district}}</td>
                                    <td class="border-1 border">{{$forum2->no_sk}}</td>
                                    <td class="border-1 border">
                                        {{ \Carbon\Carbon::parse($forum2->expired_sk)->format('d-F-Y') ?? '-' }}
                                    </td>
                                    <td class="border-1 border">{{ number_format($forum2->f_budget,0,',','.') }}</td>
                                    <td class="border-1 border">{{$forum2->s_address}}</td>

                                    @if (!is_null($forum2->path_sk_f))
                                    <td class="border-1 border text-center">
                                        <a href="{{ asset('uploads/doc_forum_kec/'.$forum2->path_sk_f) }}" target="_blank" class="btn btn-success btn-sm ">
                                            <div class="d-flex justify-content-center">
                                                Lihat
                                            </div>
                                        </a>
                                    </td>
                                    @else
                                    <td class="border-1 border text-center">
                                        <div class="badge badge-light-danger">Belum diupload</div>
                                    </td>
                                    @endif

                                    @if (!is_null($forum2->path_plan_f))
                                    <td class="border-1 border text-center">
                                        <a href="{{ asset('uploads/doc_forum_kec/'.$forum2->path_plan_f) }}" target="_blank" class="btn btn-success btn-sm ">
                                            <div class="d-flex justify-content-center">
                                                Lihat
                                            </div>
                                        </a>
                                    </td>
                                    @else
                                    <td class="border-1 border text-center">
                                        <div class="badge badge-light-danger">Belum diupload</div>
                                    </td>
                                    @endif

                                    @if (!is_null($forum2->path_budget))
                                    <td class="border-1 border text-center">
                                        <a href="{{ asset('uploads/doc_forum_kec/'.$forum2->path_budget) }}" target="_blank" class="btn btn-success btn-sm ">
                                            <div class="d-flex justify-content-center">
                                                Lihat
                                            </div>
                                        </a>
                                    </td>
                                    @else
                                    <td class="border-1 border text-center">
                                        <div class="badge badge-light-danger">Belum diupload</div>
                                    </td>
                                    @endif

                                    @if (!is_null($forum2->path_s))
                                    <td class="border-1 border text-center">
                                        <a href="{{ asset('uploads/doc_forum_kec/'.$forum2->path_s) }}" target="_blank" class="btn btn-success btn-sm ">
                                            <div class="d-flex justify-content-center">
                                                Lihat
                                            </div>
                                        </a>
                                    </td>
                                    @else
                                    <td class="border-1 border text-center">
                                        <div class="badge badge-light-danger">Belum diupload</div>
                                    </td>
                                    @endif
                                @else
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>
                                    <td class="border-1 border">-</td>

                                @endif
                                
                                
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Kegiatan Forum Kecamatan</h3>
            </div>
        </div>
        <div class="card-body">
            
            <div class="table-responsive mt-3">
                <table  class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-w-60px text-center border-1 border">No.</th>
                            <th class="min-w-60px text-center border-1 border"></th>
                            <th class="min-w-200px border-1 border">Nama Kecamatan</th>
                            <th class="min-w-200px border-1 border text-center">Nama Kegiatan</th>
                            <th class="min-w-200px border-1 border text-center">Waktu</th>
                            <th class="min-w-150px border-1 border text-center">Jumlah Peserta</th>
                            <th class="min-w-200px -bottom-3border-1 border">Hasil</th>
                            <th class="min-w-200px border-1 border">Keterangan</th>
                            <th class="min-w-100px border-1 border text-center">Dokumen</th>
                            <th class="min-w-100px border-1 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subdistrict as $index => $item)
                            @php
                                $subdistrictActivities = $activity->where('id_kode', $item->id);
                                $activityCount = $subdistrictActivities->count();
                                $firstRow = true;
                            @endphp
                            @if ($activityCount > 0)
                                @foreach ($subdistrictActivities as $key => $item_v2)
                                    <tr>
                                        @if ($firstRow)
                                            <td class="border-1 border text-center" rowspan="{{ $activityCount }}">{{ $index + 1 }}</td>
                                            <td class="border-1 border text-center" rowspan="{{ $activityCount }}">
                                                <a href="{{ route('act-kec.createActivityKec', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="nav-icon fas fa-folder-plus"></i>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="border-1 border" rowspan="{{ $activityCount }}">{{ $item->name }}</td>
                                            @php $firstRow = false; @endphp
                                        @endif

                                        
                                        <td class="border-1 border ps-3 align-middle">{{ $item_v2->name }}</td>
                                        <td class="border-1 border text-center align-middle">
                                            {{ \Carbon\Carbon::parse($item_v2->time)->format('d-F-Y') ?? '-' }}
                                        </td>
                                        <td class="border-1 border text-center align-middle">{{ $item_v2->participant ?? '-' }}</td>
                                        <td class="border-1 border align-middle">{{ $item_v2->result ?? '-' }}</td>
                                        <td class="border-1 border align-middle">{{ $item_v2->note ?? '-' }}</td>
                                        @if (!is_null($item_v2->path))
                                            <td class="border-1 border text-center">
                                                <a href="{{ asset('uploads/doc_activity/'.$item_v2->path) }}" target="_blank" class="btn btn-success btn-sm">
                                                    <div class="d-flex justify-content-center">
                                                        Lihat
                                                    </div>
                                                </a>
                                            </td>
                                        @else
                                            <td class="border-1 border text-center align-middle">
                                                <div class="badge badge-light-danger">Belum diupload</div>
                                            </td>
                                        @endif
                                        <td class="border border-1 text-center">
                                            <a href="{{ route('kelembagaan-v2.editActivity', $item_v2->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                                <div class="d-flex justify-content-center">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </div>
                                            </a>
                                            <button class="btn btn-icon btn-danger w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}" data-bs-toggle="modal" data-bs-target="#confirmDeleteActivity{{ $item_v2->id }}">
                                                <div class="d-flex justify-content-center">
                                                    <i class="fa-solid fa-trash"></i>
                                                </div>
                                            </button>
                                            <div class="modal text-start fade" tabindex="-1" id="confirmDeleteActivity{{ $item_v2->id }}">
                                                <form action="{{ route('kelembagaan-v2.destroyActivity', $item_v2->id) }}" method="POST">
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
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="border-1 border text-center">{{ $index + 1 }}</td>
                                    <td class="border-1 border text-center">
                                        <a href="{{ route('act-kec.createActivityKec', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="nav-icon fas fa-folder-plus"></i>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="border-1 border">{{ $item->name }}</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                </tr>
                            @endif
                           
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- pokja --}}
    @elseif($category && $category->is_status == 3)
    
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3>SK dan Kegiatan Pokja Desa/Kelurahan</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableForumKel" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-w-60px text-center border-1 border">No.</th>
                            <th class="min-w-200px border-1 border">Nama Kecamatan</th>
                            <th class="min-w-200px border-1 border">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($subdistrict as $item)
                           <tr>
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="border-1 border">{{$item->name}}</td>
                                <td class="border-1 border">
                                    <a href="{{route('pokja-desa.showPokjaDesa',[$category->id, $item->id])}}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat detailnya
                                    </a>
                                </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @elseif($category && $category->is_status == 0)
    
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3>SK dan Renja {{$category->name}}</h3>
            </div>
            <div class="card-toolbar">
                <button 
                    @if ($now >= $start && $now <= $end)
                        type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pembinaCreate"
                    @else
                        class="btn  btn btn-primary btn-sm" disabled
                    @endif>
                    Edit
                </button>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">No SK Tim Pembina</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-bold fs-6 text-gray-800">{{$pembina->sk_pembina ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">No SK Rencana Kerja</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6" >{{$pembina->renja ?? 'Belum ada'}}</span>
                </div>
            </div>
        </div>
    </div>

    @elseif($category && $category->is_status == 1)
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3>SK dan Renja {{$category->name}}</h3>
            </div>
            <div class="card-toolbar">
                <button 
                    @if ($now >= $start && $now <= $end)
                        type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#FKabkotaCreate"
                    @else
                        class="btn  btn btn-primary btn-sm" disabled
                    @endif>
                    Edit
                </button>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">Nomor SK Forum Kab/Kota</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-bold fs-6 text-gray-800">{{$forum_kabkota->sk_forum_kabkota ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-3 fw-semibold text-muted">No SK Rencana Kerja</label>
                <div class="col-lg-9 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6" >{{$forum_kabkota->renja_forum_kabkota ?? 'Belum ada'}}</span>
                </div>
            </div>
        </div>
    </div>

    @endif

    @if ($category->is_status == 0 || $category->is_status == 1)
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Kegiatan</h3>
            </div>
        </div>
        <div class="card-body">
            <button 
                @if ($now >= $start && $now <= $end)
                    type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmNewActivityV2"
                @else
                    class="btn  btn btn-primary btn-sm" disabled
                @endif>
                <i class="nav-icon fas fa-folder-plus "></i>Tambah
            </button>
            <div class="table-responsive mt-3">
                <table id="tableKegiatan" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-100px text-center border-1 border"></th>
                            <th class="w-200px border-1 border">Nama Kegiatan</th>
                            <th class="w-100px border-1 border">Waktu</th>
                            <th class="w-100px border-1 border">Jumlah Peserta</th>
                            <th class="w-200px border-1 border">Hasil</th>
                            <th class="w-100px border-1 border">Keterangan</th>
                            <th class="w-100px border-1 border text-center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($activity as $item)
                           <tr>
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="border border-1 text-center">
                                    <a href="{{ route('kelembagaan-v2.editActivity', $item->id) }}" 
                                        class="btn btn-icon btn-primary w-35px h-35px mb-3 {{$now >= $start && $now <= $end ? '' : 'disabled'}} " >
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button  
                                        @if ($now >= $start && $now <= $end)
                                            class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteActivity{{ $item->id }}"
                                        @else
                                            class="btn btn-icon btn-danger w-35px h-35px mb-3" disabled
                                        @endif>
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal text-start fade" tabindex="-1" id="confirmDeleteActivity{{ $item->id }}">
                                        <form action="{{ route('kelembagaan-v2.destroyActivity', $item->id) }}" method="POST">
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
                                <td class="border-1 border">{{$item->name}}</td>
                                <td class="border-1 border">{{$item->time}}</td>
                                <td class="border-1 border text-center">{{$item->participant}}</td>
                                <td class="border-1 border">{{$item->result}}</td>
                                <td class="border-1 border">{{$item->note}}</td>
                                @if (!is_null($item->path))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_activity/'.$item->path) }}" target="_blank" class="btn btn-success btn-sm ">
                                        <div class="d-flex justify-content-center">
                                            Lihat
                                        </div>
                                    </a>
                                </td>
                                    <!-- Jika path tidak null -->
                                @else
                                <td class="border-1 border text-center">
                                    <div class="badge badge-light-danger">Belum diupload</div>
                                </td>
                                    <!-- Jika path null -->
                                @endif
                           </tr>
                       @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

    <div class="modal modal-lg fade text-start" tabindex="-1" id="confirmNewActivityV2" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            Tambah Kegiatan
                        </h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('kelembagaan-v2.storeActivity', $category->id)}}" enctype="multipart/form-data" >
                            @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group w-100">
                                    <label for="name" class="form-label">Nama Kegiatan</label>
                                    <input type="text"
                                        class="form-control form-control-solid rounded rounded-4"
                                        placeholder="Masukkan Nama Kegiatan"
                                        name="name"
                                        id="name"
                                        required
                                        oninvalid="this.setCustomValidity('Nama Kegiatan tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                    >
                                    @error('name')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group w-100">
                                    <label for="time" class="form-label">Waktu</label>
                                    <input type="text"
                                        id="time"
                                        class="form-control form-control-solid rounded rounded-4"
                                        placeholder="Masukkan Waktu"
                                        name="time"
                                        required
                                        oninvalid="this.setCustomValidity('Waktu tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                    >
                                    @error('time')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group w-100">
                                    <label for="participant" class="form-label">Jumlah Peserta</label>
                                    <input type="number"
                                        id="participant"
                                        class="form-control form-control-solid rounded rounded-4"
                                        placeholder="Masukkan Waktu"
                                        name="participant"
                                        required
                                        oninvalid="this.setCustomValidity('Jumlah peserta tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                    >
                                    @error('participant')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group w-100">
                                    <label for="note" class="form-label">Keterangan</label>
                                    <input type="text"
                                        id="note"
                                        class="form-control form-control-solid rounded rounded-4"
                                        placeholder="Masukkan Waktu"
                                        name="note"
                                        required
                                        oninvalid="this.setCustomValidity('Keterangan tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                    >
                                    @error('note')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group w-100">
                                    <label for="result" class="form-label">Hasil Kegiatan</label>
                                    <textarea class="form-control form-control-solid" 
                                        oninvalid="this.setCustomValidity('Hasil tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                        required 
                                        name="result" 
                                        id="result" 
                                        cols="5" rows="5" 
                                        placeholder="Masukkan Hasil Kegiatan"></textarea>
                                    @error('result')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group w-100">
                                    <label for="path" class="form-label">Bukti Kegiatan <span class="text-danger">*pdf | Max 4 MB</span> </label>
                                    <input type="file" class="form-control form-control-solid" name="path" id="path" accept=".pdf">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()" >Batal</button>
                        &nbsp;
                        <button type="submit" class="btn btn-primary rounded-4 hover-scale">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    @endif

    @if ($category && $category->is_status == 1)
        <div class="modal modal-lg fade text-start" tabindex="-1" id="FKabkotaCreate" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            Tambah SK dan Renja
                        </h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ $forum_kabkota ? route('fkabkota.update', $forum_kabkota->id) : route('fkabkota.store')}}">
                            @csrf
                            @if($forum_kabkota)
                                @method('PUT')
                            @endif
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="form-group w-100">
                                    <label for="sk_forum_kabkota" class="form-label">No SK Forum Kab/Kota</label>
                                    <input type="text"
                                        class="form-control form-control-solid rounded rounded-4"
                                        placeholder="Masukkan No SK Pembina"
                                        name="sk_forum_kabkota"
                                        id="sk_forum_kabkota"
                                        required
                                        oninvalid="this.setCustomValidity('No SK Forum Kab/Kota tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                        value="{{ old('sk_forum_kabkota', $forum_kabkota->sk_forum_kabkota ?? '') }}"
                            >
                                    
                                    @error('sk_forum_kabkota')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <div class="form-group w-100">
                                    <label for="renja_forum_kabkota" class="form-label">No SK Rencana Kerja</label>
                                    
                                    <textarea name="renja_forum_kabkota" id="renja_forum_kabkota" cols="4" rows="4"
                                        required
                                        oninvalid="this.setCustomValidity('Rencana Kerja tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                        class="form-control form-control-solid rounded rounded-4"
                                        placeholder="Masukkan Rencana Kerja"
                                    >{{ old('renja_forum_kabkota', $forum_kabkota->renja_forum_kabkota ?? '') }}</textarea>
                                    @error('renja_forum_kabkota')
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
                        <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()" >Batal</button>
                        &nbsp;
                        <button type="submit" class="btn btn-primary rounded-4 hover-scale">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($category && $category->is_status == 0)
        <div class="modal modal-lg fade text-start" tabindex="-1" id="pembinaCreate" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Tambah SK dan Renja
                            </h3>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ $pembina ? route('pembina.update', $pembina->id) : route('pembina.store')}}">
                                @csrf
                                @if($pembina)
                                    @method('PUT')
                                @endif
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <div class="form-group w-100">
                                        <label for="sk_pembina" class="form-label">No SK Pembina</label>
                                        <input type="text"
                                            class="form-control form-control-solid rounded rounded-4"
                                            placeholder="Masukkan No SK Pembina"
                                            name="sk_pembina"
                                            id="sk_pembina"
                                            required
                                            oninvalid="this.setCustomValidity('No SK Pembina tidak boleh kosong.')"
                                            oninput="this.setCustomValidity('')"
                                            value="{{ old('sk_pembina', $pembina->sk_pembina ?? '') }}"
                                >
                                        
                                        @error('sk_pembina')
                                            <div class="is-invalid">
                                                <span class="text-danger">
                                                    {{$message}}
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <div class="form-group w-100">
                                        <label for="renja" class="form-label">No SK Rencana Kerja</label>
                                        
                                        <textarea name="renja" id="renja" cols="4" rows="4"
                                            required
                                            oninvalid="this.setCustomValidity(' Rencana Kerja tidak boleh kosong.')"
                                            oninput="this.setCustomValidity('')"
                                            class="form-control form-control-solid rounded rounded-4"
                                            placeholder="Masukkan Rencana Kerja"
                                        >{{ old('renja', $pembina->renja ?? '') }}</textarea>
                                        @error('renja')
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
                            <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()" >Batal</button>
                            &nbsp;
                            <button type="submit" class="btn btn-primary rounded-4 hover-scale">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
   

   

 
@endsection

@section('script')
    <script>
       
        document.addEventListener('change', function (e) {
            if (e.target && e.target.type === 'file') {
                const file = e.target.files[0];
                const maxSize = 8 * 1024 * 1024; // 2 MB

                if (file && file.type !== 'application/pdf') {
                    Swal.fire({
                        icon: 'error',
                        title: 'File tidak valid',
                        text: 'Hanya file PDF yang diizinkan!',
                        confirmButtonText: 'Oke',
                    });
                    e.target.value = ''; // Reset input
                } else if (file && file.size > maxSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran file terlalu besar',
                        text: 'Ukuran maksimal file adalah 8 MB.',
                        confirmButtonText: 'Oke',
                    });
                    e.target.value = ''; // Reset input
                }
            }
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

        $("#tableForumKec").DataTable({
            scrollY:        "500px",
            scrollX:        true,
            scrollCollapse: true,
            fixedColumns:   {
                left: 3,
            },
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

        $("#tableKegiatan").DataTable({
            "scrollX": true,
            "autoWidth": false,
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

        $("#tableKegiatan2").DataTable({
            "stateSave": true,
            "columnDefs": "",
            "colReorder": true,
            // scrollX:        true,
            // scrollCollapse: true,
            // fixedColumns:   {
            //     left: 3,
            // },
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

        $(document).on('click', '.delete-btn', function () {
            var deleteFileId = $(this).data('id');
            // $('#confirmDeleteModal').modal('show');
            var url = '/kabkota/kelembagaan-v2/destroydoc/' + deleteFileId;

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

        $("#tableForumKel").DataTable({
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


        $("#time").flatpickr();
        $("#expired_sk").flatpickr();

        function formatRupiah(input) {
            // Hapus format sebelumnya (titik/koma) dan sisakan hanya angka
            let value = input.value.replace(/[^,\d]/g, '');
            // Tambahkan pemisah ribuan dengan titik
            const rupiah = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = rupiah;
        }

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

        //max pdf
       

        
        
    </script>

   
@endsection
