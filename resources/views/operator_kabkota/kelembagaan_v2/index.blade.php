@extends('partials.index')
@section('heading')
    Pertanyaan
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
                                                                        <th class="border border-1">Opsi Jawaban</th>
                                                                        <th class="w-300px border border-1">Nilai Jawaban</th>
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
                                                                                                required
                                                                                            >
                                                                                            <label class="form-check-label" for="name_option">{{ $opsi->name }}</label>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="border border-1">
                                                                                        <label class="form-check-label" for="score">{{ $opsi->score }}</label>
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
                                                                                                required
                                                                                                id="name_option_{{$opsi->id}}"
                                                                                            >
                                                                                            <label class="form-check-label" for="name_option_{{$opsi->id}}">{{ $opsi->name }}</label>
                                                                                        </div>

                                                                                    </td>
                                                                                    <td class="border border-1">
                                                                                        <label class="form-check-label" for="score_{{$opsi->id}}">{{ $opsi->score }}</label>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                            <div class="mb-2">
                                                                <span class="required">Data Dukung berupa Pdf dan maksimal 2 MB</span>
                                                            </div>
                                                            <table class="table mb-3 table-striped table-row-bordered border rounded">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="border border-1">Data Pendukung</th>
                                                                        <th class=" w-300px border border-1">File</th>
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
                                                                                <input type="file" name="file_path" class="form-control">
                                                                            @else
                                                                                <a href="{{ asset('uploads/doc_kelembagaan/'.$uploadedFile->path) }}" target="_blank" class="btn btn-success btn-sm ">
                                                                                    <div class="d-flex justify-content-center">
                                                                                        Lihat
                                                                                    </div>
                                                                                </a>
                                                                                <button type="submit" class="btn btn-danger btn-sm delete-btn" data-id="{{ $uploadedFile->id }}">
                                                                                    Hapus
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                </tbody>
                                                            </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal">Batal</button>
                                                        &nbsp;
                                                        <button type="submit" class="btn btn-primary rounded-4 hover-scale">Simpan</button>
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
            {{-- <button type="button" class="btn btn-primary btn-sm" id="createNewForumKec" data-bs-toggle="modal" data-bs-target="#confirmForumKec"> 
                <i class="nav-icon fas fa-folder-plus "></i>Tambah
            </button> --}}
            <div class="table-responsive mt-3">
                <table id="tableForumKec" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-w-60px text-center border-1 border">No.</th>
                            <th class="min-w-60px text-center border-1 border"></th>
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
                                <td class="border border-1 text-center">
                                    @if (is_null($forum2))
                                        <a href="{{ route('kelembagaan-v2.createForumKec', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('kelembagaan-v2.editForumKec', $item->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                    @endif
                                    {{-- <button class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteForumKec{{ $item->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal text-start fade" tabindex="-1" id="confirmDeleteForumKec{{ $item->id }}">
                                        <form action="{{ route('kelembagaan-v2.destroyForumKec', $item->id) }}" method="POST">
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
                                    </div> --}}
                                </td>
                                <td class="border-1 border">{{$item->name}}</td>
                                @if ($forum2)
                                    <td class="border-1 border">{{$forum2->f_district}}</td>
                                    <td class="border-1 border">{{$forum2->no_sk}}</td>
                                    <td class="border-1 border">{{$forum2->expired_sk}}</td>
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
                <table id="tableKegiatan2"  class="table table-striped table-row-bordered border rounded" style="width:100%">
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
                                                <a href="{{ route('act-kec.createActivityKec', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
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
                                            <a href="{{ route('kelembagaan-v2.editActivity', $item_v2->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                                <div class="d-flex justify-content-center">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </div>
                                            </a>
                                            <button class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteActivity{{ $item->id }}">
                                                <div class="d-flex justify-content-center">
                                                    <i class="fa-solid fa-trash"></i>
                                                </div>
                                            </button>
                                            <div class="modal text-start fade" tabindex="-1" id="confirmDeleteActivity{{ $item->id }}">
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
                                        <a href="{{ route('act-kec.createActivityKec', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
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
    {{-- <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3>SK Pokja Desa/Kelurahan Sehat</h3>
            </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm" id="createNewForumKel" data-bs-toggle="modal" data-bs-target="#confirmForumKel"> 
                <i class="nav-icon fas fa-folder-plus "></i>Tambah
            </button>
            <div class="table-responsive mt-3">
                <table  class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-w-60px text-center border-1 border">No.</th>
                            <th class="min-w-100px text-center border-1 border"></th>
                            <th class="min-w-200px border-1 border">Nama Kecamatan</th>
                            <th class="min-w-200px border-1 border">Nama Kelurahan</th>
                            <th class="min-w-200px border-1 border">Pokja Desa</th>
                            <th class="min-w-200px border-1 border">No. SK Pokja</th>
                            <th class="min-w-200px border-1 border">Masa Berlaku SK Pokja</th>
                            <th class="min-w-200px border-1 border">Alokasi Anggaran Pokja</th>
                            <th class="min-w-200px border-1 border">Alamat Sekretariat Pokja</th>

                            <th class="min-w-150px border-1 border text-center">Dokumen SK Pokja</th>
                            <th class="min-w-150px border-1 border text-center">Dokumen Renja Pokja</th>
                            <th class="min-w-150px border-1 border text-center">Dokumen Anggaran</th>
                            <th class="min-w-150px border-1 border text-center">Foto Sekretariat</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                       @foreach ($forumKel as $item)
                           <tr>
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="border border-1 text-center">
                                    <a href="{{ route('kelembagaan-v2.editForumDesa', $item->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteForumKec{{ $item->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                    <div class="modal text-start fade" tabindex="-1" id="confirmDeleteForumKec{{ $item->id }}">
                                        <form action="{{ route('kelembagaan-v2.destroyForumDesa', $item->id) }}" method="POST">
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
                                <td class="border-1 border">{{$item->district}}</td>
                                <td class="border-1 border">{{$item->subdistrict}}</td>
                                <td class="border-1 border">{{$item->f_subdistrict}}</td>
                                <td class="border-1 border">{{$item->no_sk}}</td>
                                <td class="border-1 border">{{$item->expired_sk}}</td>
                                <td class="border-1 border">{{$item->f_budget}}</td>
                                <td class="border-1 border">{{$item->s_address}}</td>

                                @if (!is_null($item->path_sk_f))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$item->path_sk_f) }}" target="_blank" class="btn btn-success btn-sm ">
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

                                @if (!is_null($item->path_plan_f))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$item->path_plan_f) }}" target="_blank" class="btn btn-success btn-sm ">
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

                                

                                @if (!is_null($item->path_budget))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$item->path_budget) }}" target="_blank" class="btn btn-success btn-sm ">
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

                                @if (!is_null($item->path_s))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$item->path_s) }}" target="_blank" class="btn btn-success btn-sm ">
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
                <h3>Kegiatan Pokja Desa/Kelurahan</h3>
            </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmNewActivity"> 
                <i class="nav-icon fas fa-folder-plus "></i>Tambah
            </button>
            <div class="table-responsive mt-3">
                <table id="tableKegiatan" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="border-1 border">Nama Kecamatan</th>
                            <th class="border-1 border">Nama Kegiatan</th>
                            <th class="border-1 border">Waktu</th>
                            <th class="border-1 border">Jumlah Peserta</th>
                            <th class="border-1 border">Hasil</th>
                            <th class="border-1 border">Keterangan</th>
                            <th class="border-1 border text-center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subdistrict as $item)
                           <tr>
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="border-1 border">{{$item->name}}</td>
                                @php
                                @endphp
                                @foreach ($activity as $item_v2)
                                    <td class="border-1 border">{{$item_v2->name}}</td>
                                    <td class="border-1 border text-center"></td>
                                    <td class="border-1 border"></td>
                                    <td class="border-1 border"></td>
                                    <td class="border-1 border"></td>
                                    <td class="border-1 border"></td>

                                @endforeach
                                
                                
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    
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
   
    @else
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Kegiatan</h3>
            </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmNewActivity"> 
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
                                    <a href="{{ route('kelembagaan-v2.editActivity', $item->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteActivity{{ $item->id }}">
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

    <div class="modal modal-lg fade text-start" tabindex="-1" id="confirmNewActivity" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                    <label for="number" class="form-label">Jumlah Peserta</label>
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
                                    <label for="path" class="form-label">Bukti Kegiatan <span class="text-danger">*pdf | Max 2MB</span> </label>
                                    <input type="file" class="form-control form-control-solid" name="path" id="path">
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
                        <button type="button" class="btn btn-secondary rounded-4 hover-scale" data-bs-dismiss="modal">Batal</button>
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

        
        
    </script>
@endsection
