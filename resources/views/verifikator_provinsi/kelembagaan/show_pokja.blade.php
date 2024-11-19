@extends('partials.index')
@section('heading')
    Kecamatan {{$subdistrict->name}}
@endsection
@section('page')
    Data Kecamatan {{$subdistrict->name}}
@endsection


@section('content')
   

    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3>SK Pokja Desa/Kelurahan</h3>
            </div>
        </div>
        <div class="card-body">
            <a href="{{route('v-prov.showKelembagaan',['id_zona' => $subdistrict->district_id, 'id' => $category->id])}}" class="btn-outline-primary btn-outline btn mb-4 btn-sm">
                Kembali
            </a>
            <div class="table-responsive mt-3">
                <table id="tableSKPokjaDesa" class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="min-w-60px text-center border-1 border align-middle" rowspan="2">No.</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Nama Kelurahan/Desa</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Nama Pokja Desa</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">No. SK Pokja Desa</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Masa Berlaku SK</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Alokasi Anggaran Pokja Desa</th>
                            <th class="min-w-200px border-1 border align-middle" rowspan="2">Alamat Sekretariat Pokja Desa</th>

                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Dokumen SK Pokja Desa</th>
                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Dokumen Renja Pokja Desa</th>
                            <th class="min-w-150px border-1 border text-center align-middle" rowspan="2">Dokumen Anggaran Pokja Desa</th>
                            <th class="min-w-150px border-1 border text-center align-middle"  rowspan="2">Foto Sekretariat Pokja Desa</th>
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
                    @foreach ($village as $item)
                        <tr>
                            @php
                                $forumKel2 = $forumKel->where('id_village', $item->id)->first();
                            @endphp
                            <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                                    
                            <td class="border-1 border">{{$item->name}}</td>
                            @if ($forumKel2)
                                <td class="border-1 border">{{$forumKel2->f_village}}</td>
                                <td class="border-1 border">{{$forumKel2->no_sk}}</td>
                                <td class="border-1 border">{{$forumKel2->expired_sk}}</td>
                                <td class="border-1 border">{{ number_format($forumKel2->f_budget,0,',','.') }}</td>
                                <td class="border-1 border">{{$forumKel2->s_address}}</td>

                                @if (!is_null($forumKel2->path_sk_f))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$forumKel2->path_sk_f) }}" target="_blank" class="btn btn-success btn-sm ">
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

                                @if (!is_null($forumKel2->path_plan_f))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$forumKel2->path_plan_f) }}" target="_blank" class="btn btn-success btn-sm ">
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

                                @if (!is_null($forumKel2->path_budget))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$forumKel2->path_budget) }}" target="_blank" class="btn btn-success btn-sm ">
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

                                @if (!is_null($forumKel2->path_s))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc_pokja_desa/'.$forumKel2->path_s) }}" target="_blank" class="btn btn-success btn-sm ">
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
                                    @if ($forumKel2->answer_prov == 1)
                                        Sesuai
                                    @elseif ($forumKel2->answer_prov == 2)
                                        Tidak sesuai
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-1 border text-center">
                                    {{$forumKel2->comment_prov ?? '-'}}
                                </td>
                                <td class="border-1 border text-center">
                                    @if ($forumKel2->answer_pusat == 1)
                                        Sesuai
                                    @elseif ($forumKel2->answer_pusat == 2)
                                        Tidak sesuai
                                    @else
                                        -
                                    @endif
                                    {{-- {{$item->answer_pusat === 1 ? 'Sesuai' : ($item->answer_pusat === 2 ? 'Tidak sesuai' : '-') }} --}}
                                </td>
                                <td class="border-1 border text-center">
                                    {{$forumKel2->comment_pusat ?? '-'}}
                                </td>
                                <td class="border-1 border text-center">
                                    <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmSKPokja{{ $forumKel2->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </button>
                                    <div class="modal fade text-start" tabindex="-1" id="confirmSKPokja{{ $forumKel2->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Edit Verifikasi
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('v-prov.storeSKPokja', $forumKel2->id)}}" method="POST">
                                                    @csrf
                                                    <p><strong>{{$forumKel2->f_village}}</strong></p>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="answer_prov" id="optionAda_{{$forumKel2->id}}" {{ $forumKel2->answer_prov == 1 ? 'checked' : '' }} value="1" required>
                                                        <label class="form-check-label" for="optionAda_{{$forumKel2->id}}">Sesuai</label>
                                                    </div>
                                            
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="answer_prov" id="optionTidakAda_{{$forumKel2->id}}" {{ $forumKel2->answer_prov == 2 ? 'checked' : '' }} value="2"  required>
                                                        <label class="form-check-label" for="optionTidakAda_{{$forumKel2->id}}">Tidak Sesuai</label>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <div class="form-group w-100">
                                                                <label class="form-label bold">Komentar</label>
                                                                @if (!empty($forumKel2->comment_prov))
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required>{{$forumKel2->comment_prov}}</textarea>
                                                                @else
                                                                    <textarea name="comment_prov" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar" required></textarea>
                                                                @endif
                                                                
                                                                {{-- <textarea name="comment_pusat" class="form-control form-control-solid rounded rounded-4" cols="3" rows="2" placeholder="Komentar"></textarea> --}}

                                                                
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
                                                    {{-- @if ($now >= $start && $now <= $end) --}}
                                                        type="submit" 
                                                        class="btn btn-primary rounded-4 hover-scale"
                                                    {{-- @else
                                                        class="btn btn-primary rounded-4 hover-scale" disabled
                                                    @endif --}}
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

    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3>Kegiatan Pokja Desa/Kelurahan</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableKegiatan2"  class="table table-striped table-row-bordered border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="min-w-60px text-center border-1 border align-middle" rowspan="2">No.</th>
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
                        @foreach ($village as $index => $item)
                            @php
                                $villageActivities = $activity->where('id_kode', $item->id);
                                $activityCount = $villageActivities->count();
                                $firstRow = true;
                            @endphp
                            @if ($activityCount > 0)
                                @foreach ($villageActivities as $key => $item_v2)
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
                                            {{-- {{$item->answer_pusat === 1 ? 'Sesuai' : ($item->answer_pusat === 2 ? 'Tidak sesuai' : '-') }} --}}
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
                                                            {{-- <form action="{{ route('v-pusat.storeKelembagaan', $item->id)}}" method="POST"> --}}
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
                                                            {{-- @if ($now >= $start && $now <= $end) --}}
                                                                type="submit" 
                                                                class="btn btn-primary rounded-4 hover-scale"
                                                            {{-- @else
                                                                class="btn btn-primary rounded-4 hover-scale" disabled
                                                            @endif --}}
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


   
@endsection

@section('script')
    <script>
        $("#tableSKPokjaDesa").DataTable({
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
        
        
    </script>
@endsection
