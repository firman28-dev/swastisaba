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
                <table id="tableSKPD" class="table table-striped table-row-bordered border" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border border-1">No.</th>
                            <th class="w-50 border border-1">Nama Dokumen</th>
                            <th class="w-150px border border-1">Dokumen Upload</th>
                            <th class="border border-1">Aksi</th>
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
                                    <td class="border border-1">
                                        <div class="badge badge-light-success">Sudah upload</div>
                                    </td>
                                    <td class="border border-1">
                                        <a href="{{ asset($relatedAnswerDoc->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-eye"></i>
                                            </div>
                                        </a>
                                        <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $relatedAnswerDoc->id }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-trash"></i>
                                            </div>
                                        </button>
                                        <div class="modal fade" tabindex="-1" id="confirmDelete{{ $relatedAnswerDoc->id }}">
                                            <form action="{{ route('doc-prov.destroy', $relatedAnswerDoc->id) }}" method="POST">
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
                                                            <p>Apakah yakin ingin menghapus data dokumen?</p>
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
                                @else
                                    <td class="border border-1">
                                        <div class="badge badge-light-danger">Belum upload</div>
                                    </td>
                                    <td class="border border-1">
                                        <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#createModal{{$data->id}}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-square-plus"></i>
                                            </div>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" tabindex="-1" id="createModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false">>
                                            <form action="{{route('doc-prov.store', $data->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">
                                                                Input Dokumen Data Umum
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-lg-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label">Dokumen</label>
                                                                    <input type="file" name="path" class="form-control form-control-solid rounded rounded-4" placeholder="File">
                                                                    <p><span class="required"></span> Dokumen berupa Pdf dan maksimal 2 MB</p>

                                                                    {{-- @error('path')
                                                                        <div class="is-invalid">
                                                                            <span class="text-danger">
                                                                                {{$message}}
                                                                            </span>
                                                                        </div>
                                                                    @enderror --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary rounded-4">SImpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @if ($doc && $doc->status_kelembagaan == 2)
    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title">
                Capaian Pembinaan Penyelenggaraan KKS 
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableCPembinaan" class="table table-striped table-row-bordered border" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border border-1 align-middle" rowspan="2">No.</th>
                            <th class="w-200px border border-1 align-middle text-center" rowspan="2">Kabupaten/Kota</th>
                            <th class="w-200px border border-1 align-middle text-center" colspan="2">SK Tim Pembina</th>
                            <th class="w-200px border border-1 align-middle text-center" colspan="2">SK Forum</th>
                        </tr>

                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-200px text-center border border-1 align-middle">No SK</th>
                            <th class="w-200px border border-1 align-middle text-center">Rencana Kerja</th>
                            <th class="w-200px text-center border border-1 align-middle">No SK</th>
                            <th class="w-200px border border-1 align-middle text-center">Rencana Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($district as $data)
                        <tr>
                            <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                            <td class="text-capitalize border border-1">{{ $data->name }}</td>
                            @php
                                $pembina_v2 = $pembina->where('id_zona', $data->id)->first();
                                $forum_kabkota_v2 = $forum_kabkota->where('id_zona', $data->id)->first();

                            @endphp
                            @if ($pembina_v2)
                                <td class="border border-1">{{$pembina_v2->sk_pembina ?? 'Belum isi'}}</td>
                                <td class="border border-1">{{$pembina_v2->renja ?? 'Belum isi'}}</td>
                            @else
                                <td class="border border-1 text-center">-</td>
                                <td class="border border-1 text-center">-</td>
                            @endif

                            @if ($forum_kabkota_v2)
                                <td class="border border-1">{{$forum_kabkota_v2->sk_forum_kabkota ?? 'Belum isi'}}</td>
                                <td class="border border-1">{{$forum_kabkota_v2->renja_forum_kabkota ?? 'Belum isi'}}</td>
                            @else
                                <td class="border border-1 text-center">-</td>
                                <td class="border border-1 text-center">-</td>
                            @endif

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title">
                Rekapitulasi Capaian Penyelenggaraan KKS
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableRealisasi" class="table table-striped table-row-bordered border" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-10px text-center border border-1 align-middle" rowspan="2">No.</th>
                            <th class="w-40px border border-1 align-middle " rowspan="2">Kab/Kota</th>
                            <th class="w-50px border border-1 text-center align-middle " rowspan="2">Prasyarat ODF (%)</th>
                            <th class="w-150px border border-1 text-center align-middle " colspan="2">Kelembagaan</th>
                            <th class="w-150px border border-1 text-center align-middle " colspan="{{$category->count()}}" >Persentase Per Tatanan</th>
                            <th class="w-150px border border-1 text-center align-middle " rowspan="2">Usulan Swastisaba</th>
                        </tr>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="text-center border-1 border align-middle p-3">Lengkap</th>
                            <th class="text-center border-1 border align-middle p-3">Tidak Lengkap</th>
                            @foreach ($category as $c)
                                <th class="text-center border-1 border align-middle p-3">T{{ $loop->iteration }}</th>
                                {{-- <th class="text-center border-1 border align-middle p-3">{{ $data->name }}</th> --}}

                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($district as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border border-1">{{ $data->name }}</td>
                                @php
                                    $odf_v2 = $odf->where('id_zona', $data->id)->first();
                                @endphp
                                @if ($odf_v2)
                                    <td class="border border-1 text-center">{{ $odf_v2->percentage }}</td>
                                    <td class="border border-1 text-center">
                                        <i class="fa-solid fa-check text-success"></i>
                                    </td>
                                    <td class="border border-1 text-center">-</td>

                                @else
                                    <td class="border border-1 text-center">-</td>
                                    <td class="border border-1 text-center">-</td>
                                    <td class="border border-1 text-center">
                                        <i class="fa-solid fa-check text-success"></i>
                                    </td>
                                @endif

                                @foreach ($category as $c)
                                    @php
                                        $question_v2 = $question->where('id_category', $c->id)->count();
                                        $total_q = $question_v2*100;
                                        $answerSuccess = $answer->where('id_category', $c->id)->where('id_zona', $data->id)->count();

                                        $yourScore = \DB::table('trans_survey_d_answer')
                                            ->join('m_question_options', 'trans_survey_d_answer.id_option', '=', 'm_question_options.id')
                                            ->where('trans_survey_d_answer.id_category', $c->id)
                                            ->where('trans_survey_d_answer.id_zona', $data->id)
                                            ->sum('m_question_options.score');
                                        // $answer_v2 = $answer->where('id_zona', $data->id)->where('id_category', $c->id)->first();
                                        $percentage = $total_q > 0 ? round(($yourScore / $total_q) * 100, 2) : 0;
                                    @endphp
                                    <td class="border border-1 text-center">
                                        {{$percentage}}
                                    </td>
                                @endforeach
                                

                                @if ($odf_v2)
                                    <td class="border border-1 text-center">{{$odf_v2->_proposal->name}}</td>
                                @else
                                    <td class="border border-1 text-center">-</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if ($doc && $doc->status_activity == 2)
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Kegiatan</h3>
            </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#confirmNewActivity">
                <i class="nav-icon fas fa-folder-plus "></i>Tambah
            </button>
            <div class="table-responsive mt-3">
                <table id="tableKegiatan" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-100px text-center border-1 border"></th>
                            <th class="w-200px border-1 border">Nama Kegiatan</th>
                            <th class="w-100px border-1 border text-center">Waktu</th>
                            <th class="w-60px border-1 border">Jumlah Peserta</th>
                            <th class="w-200px border-1 border">Hasil</th>
                            <th class="w-200px border-1 border">Keterangan</th>
                            <th class="w-100px border-1 border text-center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activity as $item)
                            <tr>
                                <td class="border border-1 text-center">{{$loop->iteration}}</td>
                                <td class="border border-1 text-center">
                                    <a href="{{ route('doc-prov.editActivity', [$item->id, $doc->id,]) }}" 
                                        class="btn btn-icon btn-primary w-35px h-35px mb-3 " >
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
                                        <form action="{{ route('doc-prov.destroyActivity', $item->id) }}" method="POST">
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
                                    <a href="{{ asset('uploads/doc_activity_prov/'.$item->path) }}" target="_blank" class="btn btn-success btn-sm ">
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

    <div class="modal modal-lg fade text-start" tabindex="-1" id="confirmNewActivity" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            Tambah Kegiatan
                        </h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('doc-prov.storeActivity')}}" enctype="multipart/form-data" >
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
                                    <label for="path" class="form-label">Bukti Kegiatan <span class="text-danger">*pdf | Max 2MB</span> </label>
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
@endsection

@section('script')
    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 2 * 1024 * 1024; // 2 MB

            if (file && file.type !== 'application/pdf') {
                alert('File harus berformat PDF.');
                e.target.value = ''; // Reset input
            } else if (file && file.size > maxSize) {
                // alert('Ukuran file tidak boleh lebih dari 2 MB.');
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran file terlalu besar',
                    text: 'Ukuran maksimal file adalah 2 MB.',
                    confirmButtonText: 'Oke',
                });
                e.target.value = ''; // Reset input
            }
        });

        $("#time").flatpickr();

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

        $("#tableKegiatan").DataTable({
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
