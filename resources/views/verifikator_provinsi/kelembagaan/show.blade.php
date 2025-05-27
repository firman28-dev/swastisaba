@extends('partials.index')
@section('heading')
    {{$zona->name}}
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
    {{-- <div class="card mb-5 mb-xl-10">
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
        
    </div> --}}

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
                <h3>{{$category->name ?? '-'}}</h3>
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
                            <th class="w-60px text-center border-1 border p-3" rowspan="2">No.</th>
                            <th class="w-50px text-center border-1 border align-middle p-3" rowspan="2">Pertanyaan</th>
                            <th class="text-center border-1 border align-middle" colspan="5">Self Assesment Kab/Kota</th>
                            <th class="text-center border-1 border align-middle" colspan="4">Provinsi</th>
                            {{-- <th class="text-center border-1 border align-middle" colspan="3">Pusat</th> --}}
                            <th class="w-100px text-center border-1 border align-middle p-3" rowspan="2">Aksi</th>

                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                            <th class="text-center border-1 border align-middle p-3">Nilai</th>
                            <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                            <th class="text-center border-1 border align-middle p-3">Status Dokumen</th>
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
                        @foreach ($questions as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->indikator }}</td>
                            @php
                                $relatedAnswer = $answer->where('id_q_kelembagaan', $item->id)->first(); // This will return a single instance or null
                                $uploadedFile = $uploadedFiles->where('id_q_kelembagaan', $item->id);
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
                                <td class="border-1 border p-3">-</td>



                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>


                                {{-- <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td>
                                <td class="border-1 border p-3">-</td> --}}
                            @endif

                            <td class="border-1 border p-3 text-center">
                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        {{-- <i class="fas fa-pen-nib"></i> --}}
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                                <div class="modal modal-lg fade text-start" tabindex="-1" id="confirmUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Edit Jawaban
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('v-prov.storeKelembagaan', ['id_zona' => $zona->id, 'id' => $item->id])}}" method="POST">
                                                    @csrf
                                                    <p>
                                                        <strong>Pertanyaan:</strong> 
                                                        <button type="button" class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="popover" data-bs-placement="right" title="Data Operasional" data-bs-custom-class="popover-inverse" data-bs-dismiss="true" data-bs-content="{{$item->d_operational}}">
                                                            <i class="fa fa-info-circle"></i>
                                                        </button>
                                                    </p>
                                                    <p>{{$item->indikator}}</p>
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
                                                                $relatedAnswer = $answer->where('id_q_kelembagaan', $item->id)->first();
                                                            @endphp
                                                            @if($relatedAnswer)
                                                                @foreach ($item->_q_option as $opsi)
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
                                                                                        required
                                                                                        @if($relatedAnswer->id_opt_kelembagaan_prov == $opsi->id) checked @endif
                                                                                        {{-- @if ($now >= $start && $now <= $end) 
                                                                                            required 
                                                                                        @else 
                                                                                            disabled 
                                                                                        @endif --}}
                                                                                    >
                                                                                    <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                                    {{-- <label class="form-check-label" for="name_option">{{ $opsi->name }}</label> --}}
                                                                                </div>
                                                                            </td>
                                                                            <td class="border border-1">
                                                                                <label class="form-check-label">{{ $opsi->score }}</label>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    
                                                                @endforeach
                                                            @else
                                                                @foreach ($item->_q_option as $opsi)
                                                                    @if ($opsi->id_survey == $sessionDate)
                                                                        <tr>
                                                                            <td class="border border-1">
                                                                                <div class="form-check form-check-custom form-check-solid">
                                                                                    <input 
                                                                                        class="form-check-input" 
                                                                                        type="radio" 
                                                                                        name="id_option" 
                                                                                        value="{{ $opsi->id }}" 
                                                                                        required
                                                                                        {{-- @if ($now >= $start && $now <= $end) 
                                                                                            required 
                                                                                        @else 
                                                                                            disabled 
                                                                                        @endif --}}
                                                                                        id="name_option_{{$opsi->id}}"
                                                                                    >
                                                                                    <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                                    {{-- <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label> --}}
                                                                                </div>

                                                                            </td>
                                                                            <td class="border border-1">
                                                                                <label class="form-check-label">{{ $opsi->score }}</label>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <div class="row mb-5">
                                                                
                                                        @if ($category && $category->is_status == 0 || $category->is_status == 1)
                                                            <div class="col-lg-6">
                                                                <div class="form-group w-100">
                                                                    <label for="achievement1" class="form-label">Capaian {{$date->trans_date}}</label>
                                                                    <input type="text"
                                                                        name="achievement"
                                                                        id="achievement1"
                                                                        class="form-control form-control-solid rounded rounded-4"
                                                                        oninvalid="this.setCustomValidity('Capaian tidak boleh kosong.')"
                                                                        oninput="this.setCustomValidity('')"
                                                                        readonly
                                                                        placeholder="Capaian"
                                                                        @if ($relatedAnswer)
                                                                            value="{{$relatedAnswer->achievement}}"
                                                                        @endif
                                                                    >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group w-100">
                                                                    <label for="notes1" class="form-label">Penjelasan</label>
                                                                    <textarea 
                                                                        name="note" 
                                                                        id="notes1" cols="3" rows="3" 
                                                                        class="form-control form-control-solid" placeholder="Penjelasan"
                                                                        readonly
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
                                                                    <label for="achievement2" class="form-label">Capaian {{$date->trans_date}}</label>
                                                                    <input type="number"
                                                                        name="achievement"
                                                                        id="achievement2"
                                                                        class="form-control form-control-solid rounded rounded-4"
                                                                        readonly
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
                                                                    <label for="notes2" class="form-label">Penjelasan</label>
                                                                    <textarea 
                                                                        name="note" 
                                                                        id="notes2" cols="3" rows="3" 
                                                                        class="form-control form-control-solid" placeholder="Penjelasan"
                                                                        readonly
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
                                                                    <label for="achievement3" class="form-label">Capaian {{$date->trans_date}}</label>
                                                                    <input type="number"
                                                                        name="achievement"
                                                                        id="achievement3"
                                                                        class="form-control form-control-solid rounded rounded-4"
                                                                        oninvalid="this.setCustomValidity('Capaian tidak boleh kosong dan maksimal {{$sum_village}}.')"
                                                                        oninput="this.setCustomValidity('')"
                                                                        readonly
                                                                        max="{{$sum_village}}"
                                                                        @if ($relatedAnswer)
                                                                            value="{{$relatedAnswer->achievement}}"
                                                                        @endif
                                                                    >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group w-100">
                                                                    <label for="notes3" class="form-label">Penjelasan</label>
                                                                    <textarea 
                                                                        name="note" 
                                                                        id="notes3" cols="3" rows="3" 
                                                                        class="form-control form-control-solid" placeholder="Penjelasan"
                                                                        readonly
                                                                    >@if ($relatedAnswer){{$relatedAnswer->note}}@endif</textarea>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                     @if ($date->id == 5)
                                                    <span>Data Dukung Tahun 2023</span>
                                                        <table class="table mb-4 table-striped table-row-bordered border rounded">
                                                             <thead>
                                                                <tr>
                                                                    <th class="w-50 border border-1">Data Pendukung</th>
                                                                    <th class="border border-1">File</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $category1 = \App\Models\M_C_Kelembagaan_New::where('id', $item->id_c_kelembagaan_v2)
                                                                        ->first();
                                                                    
                                                                    $category2 = \App\Models\M_C_Kelembagaan_New::where('id_survey', 7)
                                                                        ->where('name',$category1->name)
                                                                        ->first();
                                                                    $question2023 = \App\Models\M_Q_Kelembagaan_New::where('indikator', $item->indikator)
                                                                        ->where('id_c_kelembagaan_v2', $category2->id)
                                                                        ->first()
                                                                @endphp
                                                                <tr>
                                                                    <td class="border border-1">
                                                                        {{ $question2023->data_dukung }}
                                                                    </td>
                                                                    @php
                                                                        $uploadedFile2 = \App\Models\Trans_Doc_Kelembagaan::where('id_zona',$zona->id)
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
                                                    
                                                    <span>Data Dukung Tahun {{$date->trans_date}}</span>
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
                                                                    {{$item->data_dukung}}
                                                                </td>

                                                                @php
                                                                    $uploadedFile = $uploadedFiles->where('id_q_kelembagaan', $item->id)->first();
                                                                @endphp
                                                                @if ($uploadedFile && $uploadedFile->path)
                                                                    <td class="border border-1">
                                                                        <a href="{{ asset('uploads/doc_kelembagaan/'.$uploadedFile->path) }}" target="_blank" class="btn btn-success btn-sm ">
                                                                            <div class="d-flex justify-content-center">
                                                                                Lihat
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td class="border border-1">
                                                                        <div class="badge badge-light-danger">Tidak diupload</div>
                                                                    </td>
                                                                @endif
                                                                
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>

                                                    <div class="row mb-3 mt-3 gap-3">
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="comment_prov" class="form-label bold">Catatan Umum Verifikasi<span class="required"></span></label>
                                                                @if (!empty($relatedAnswer->comment_prov))
                                                                    <textarea name="comment_prov" id="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Umum" required>{{$relatedAnswer->comment_prov}}</textarea>
                                                                @else
                                                                    <textarea name="comment_prov" id="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Umum" required></textarea>
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
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label for="comment_prov" class="form-label bold">Catatan Detail Verifikasi<span class="required"></span></label>
                                                                @if (!empty($relatedAnswer->comment_detail_prov))
                                                                    <textarea name="comment_detail_prov" id="comment_detail_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Detail" required>{{$relatedAnswer->comment_detail_prov}}</textarea>
                                                                @else
                                                                    <textarea name="comment_detail_prov" id="comment_detail_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Catatan Detail" required></textarea>
                                                                @endif
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

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal">Batal</button>
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
{{-- 
    @php
        $c_v2 = $category;
    @endphp

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
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="min-w-60px text-center border-1 border" rowspan="2">No.</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Nama Kecamatan</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Forum Kecamatan</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">No. SK</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Masa Berlaku SK</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Alokasi Anggaran Forum</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Alamat Sekretariat Forum</th>

                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Dokumen SK Forum</th>
                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Dokumen Renja Forum</th>
                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Dokumen Anggaran</th>
                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Foto Sekretariat</th>

                            <th class="text-center border-1 border align-middle " colspan="2">Provinsi</th>
                            <th class="text-center border-1 border align-middle" colspan="2">Pusat</th>
                            <th class="min-w-100px border-1 border text-center align-middle" rowspan="2">Aksi</th>
                        </tr>

                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Komentar</th>
                            
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Komentar</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($subdistrict as $item)
                        <tr>
                            @php
                                $forum2 = $forumKec->where('id_subdistrict', $item->id)->first();
                            @endphp
                            <td class="border-1 border text-center">{{ $loop->iteration }}</td>
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
                                <td class="border-1 border text-center">
                                    @if ($forum2->answer_prov == 1)
                                        Sesuai
                                    @elseif ($forum2->answer_prov == 2)
                                        Tidak sesuai
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-1 border text-center">
                                    {{$forum2->comment_prov ?? '-'}}
                                </td>
                                <td class="border-1 border text-center">
                                    @if ($forum2->answer_pusat == 1)
                                        Sesuai
                                    @elseif ($forum2->answer_pusat == 2)
                                        Tidak sesuai
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-1 border text-center">
                                    {{$forum2->comment_pusat ?? '-'}}
                                </td>
                                <td class="border-1 border text-center">
                                    <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmSKPokja{{ $forum2->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade text-start" tabindex="-1" id="confirmSKPokja{{ $forum2->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Edit Verifikasi SK Kecamatan
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('v-prov.storeSKKec', $forum2->id)}}" method="POST">
                                                    @csrf
                                                    <p><strong>{{$forum2->f_district}}</strong></p>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="answer_prov" id="optionAda_{{$forum2->id}}" {{ $forum2->answer_prov == 1 ? 'checked' : '' }} value="1" required>
                                                        <label class="form-check-label" for="optionAda_{{$forum2->id}}">Sesuai</label>
                                                    </div>
                                            
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="answer_prov" id="optionTidakAda_{{$forum2->id}}" {{ $forum2->answer_prov == 2 ? 'checked' : '' }} value="2"  required>
                                                        <label class="form-check-label" for="optionTidakAda_{{$forum2->id}}">Tidak Sesuai</label>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label class="form-label bold">Komentar</label>
                                                                @if (!empty($forum2->comment_prov))
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required>{{$forum2->comment_prov}}</textarea>
                                                                @else
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required></textarea>
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
                                                    <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                                    &nbsp;
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-primary rounded-4 hover-scale"
                                                    >
                                                        Simpan
                                                    </button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>

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
                                <td class="border-1 border">-</td>
                                <td class="border-1 border">-</td>
                                <td class="border-1 border">-</td>
                                <td class="border-1 border">-</td>
                                <td class="border-1 border text-center">-</td>
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
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="min-w-60px text-center border-1 border align-middle"  rowspan="2" >No.</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Nama Kecamatan</th>
                            <th class="min-w-200px border-1 border text-center align-middle" rowspan="2">Nama Kegiatan</th>
                            <th class="min-w-200px border-1 border text-center align-middle" rowspan="2">Waktu</th>
                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Jumlah Peserta</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Hasil</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Keterangan</th>
                            <th class="min-w-100px border-1 border text-center align-middle" rowspan="2">Dokumen</th>
                            <th class="text-center border-1 border align-middle" colspan="2">Provinsi</th>
                            <th class="text-center border-1 border align-middle" colspan="2">Pusat</th>
                            <th class="min-w-100px border-1 border text-center align-middle" rowspan="2">Aksi</th>
                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Komentar</th>
                            
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Komentar</th>

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
                                        <td class="border-1 border text-center">
                                            @if ($item_v2->answer_prov == 1)
                                                Sesuai
                                            @elseif ($item_v2->answer_prov == 2)
                                                Tidak sesuai
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="border-1 border text-center">
                                            {{$item_v2->comment_prov ?? '-'}}
                                        </td>
                                        <td class="border-1 border text-center">
                                            @if ($item_v2->answer_pusat == 1)
                                                Sesuai
                                            @elseif ($item_v2->answer_pusat == 2)
                                                Tidak sesuai
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="border-1 border text-center">
                                            {{$item_v2->comment_pusat ?? '-'}}
                                        </td>
                                        <td class="border border-1 text-center">
                                            <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmEditVPusat2{{ $item_v2->id }}">
                                                <div class="d-flex justify-content-center">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </div>
                                            </button>
                                            <div class="modal fade text-start" tabindex="-1" id="confirmEditVPusat2{{ $item_v2->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">
                                                                Edit Verifikasi
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('v-prov.storeActivity', $item_v2->id)}}" method="POST">
                                                            @csrf
                                                            <p><strong>{{$item_v2->name}}</strong></p>
                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input" type="radio" name="answer_prov" id="optionAda_{{$item_v2->id}}" value="1" {{ $item_v2->answer_prov == 1 ? 'checked' : '' }} required>
                                                                <label class="form-check-label" for="optionAda_{{$item_v2->id}}">Sesuai</label>
                                                            </div>
                                                    
                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input" type="radio" name="answer_prov" id="optionTidakAda_{{$item_v2->id}}" value="2" {{ $item_v2->answer_prov == 2 ? 'checked' : '' }} required>
                                                                <label class="form-check-label" for="optionTidakAda_{{$item_v2->id}}">Tidak Sesuai</label>
                                                            </div>
        
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <div class="form-group w-100">
                                                                        <label class="form-label bold">Komentar</label>
                                                                        @if (!empty($item_v2->comment_prov))
                                                                            <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required>{{$item_v2->comment_prov}}</textarea>
                                                                        @else
                                                                            <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required></textarea>
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
                                                            <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                                            &nbsp;
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-primary rounded-4 hover-scale"
                                                            >
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
                            @else
                                <tr>
                                    <td class="border-1 border text-center">{{ $index + 1 }}</td>
                                    <td class="border-1 border">{{ $item->name }}</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
                                    <td class="border-1 border text-center align-middle" >-</td>
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
                                <a href="{{route('v-prov.showPokjaDesa',[$category->id, $item->id])}}" class="btn btn-outline btn-outline-success btn-sm">
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

    @else
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Kegiatan</h3>
            </div>
        </div>
        <div class="card-body">
        
            <div class="table-responsive mt-3">
                <table id="tableKegiatan" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border" rowspan="2">No.</th>
                            <th class="w-200px border-1 border align-middle" rowspan="2">Nama Kegiatan</th>
                            <th class="w-200px border-1 border align-middle" rowspan="2">Waktu</th>
                            <th class="w-200px border-1 border text-center align-middle" rowspan="2">Jumlah Peserta</th>
                            <th class="border-1 border align-middle" rowspan="2">Hasil</th>
                            <th class="border-1 border align-middle" rowspan="2">Keterangan</th>
                            <th class="border-1 border text-center align-middle" rowspan="2">Dokumen</th>
                            <th class="text-center border-1 border align-middle" colspan="2">Provinsi</th>
                            <th class="text-center border-1 border align-middle" colspan="2">Pusat</th>
                            <th class="w-100px border-1 border text-center align-middle" rowspan="2">Aksi</th>
                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Komentar</th>
                            
                            <th class="text-center border-1 border align-middle p-3">Status</th>
                            <th class="text-center border-1 border align-middle p-3">Komentar</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($activity as $item)
                        <tr>
                            <td class="border-1 border text-center">{{ $loop->iteration }}</td>
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
                            @else
                            <td class="border-1 border text-center">
                                <div class="badge badge-light-danger">Belum diupload</div>
                            </td>
                            @endif
                            <td class="border-1 border text-center">
                                @if ($item->answer_prov == 1)
                                    Sesuai
                                @elseif ($item->answer_prov == 2)
                                    Tidak sesuai
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border-1 border text-center">
                                {{$item->comment_prov ?? '-'}}
                            </td>
                            <td class="border-1 border text-center">
                                @if ($item->answer_pusat == 1)
                                    Sesuai
                                @elseif ($item->answer_pusat == 2)
                                    Tidak sesuai
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border-1 border text-center">
                                {{$item->comment_pusat ?? '-'}}
                            </td>
                            <td class="border border-1 text-center">
                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmEditVPusat{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                                <div class="modal fade text-start" tabindex="-1" id="confirmEditVPusat{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">
                                                    Edit Verifikasi Kegiatan
                                                </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('v-prov.storeActivity', $item->id)}}" method="POST">
                                                @csrf
                                                <p><strong>{{$item->name}}</strong></p>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="answer_prov" id="optionAda_{{$item->id}}" value="1" {{ $item->answer_prov == 1 ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="optionAda_{{$item->id}}">Sesuai</label>
                                                </div>
                                        
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="answer_prov" id="optionTidakAda_{{$item->id}}" value="2" {{ $item->answer_prov == 2 ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="optionTidakAda_{{$item->id}}">Tidak Sesuai</label>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <div class="form-group w-100">
                                                            <label class="form-label bold">Komentar</label>
                                                            @if (!empty($item->comment_prov))
                                                                <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar">{{$item->comment_prov}}</textarea>
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
                                                <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                                &nbsp;
                                                <button 
                                                    type="submit" 
                                                    class="btn btn-primary rounded-4 hover-scale"
                                                >
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

    @endif --}}


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

        $("#tableForumKec").DataTable({
            scrollCollapse: true,
            fixedColumns:   {
                left: 2,
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
