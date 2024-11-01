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
        <a href="{{route('kelembagaan-v2.show',$category->id)}}" class="btn-outline-primary btn-outline btn mb-4 btn-sm">
            Kembali
        </a>
        <div class="table-responsive mt-3">
            <table id="tableSKPokjaDesa" class="table table-striped table-row-bordered border rounded" style="width:100%">
                <thead>
                    <tr>
                        <th class="min-w-60px text-center border-1 border">No.</th>
                        <th class="min-w-100px text-center border-1 border"></th>
                        <th class="min-w-200px border-1 border">Nama Kelurahan/Desa</th>
                        <th class="min-w-200px border-1 border">Nama Pokja Desa</th>
                        <th class="min-w-200px border-1 border">No. SK Pokja Desa</th>
                        <th class="min-w-200px border-1 border">Masa Berlaku SK</th>
                        <th class="min-w-200px border-1 border">Alokasi Anggaran Pokja Desa</th>
                        <th class="min-w-200px border-1 border">Alamat Sekretariat Pokja Desa</th>

                        <th class="min-w-150px border-1 border text-center">Dokumen SK Pokja Desa</th>
                        <th class="min-w-150px border-1 border text-center">Dokumen Renja Pokja Desa</th>
                        <th class="min-w-150px border-1 border text-center">Dokumen Anggaran Pokja Desa</th>
                        <th class="min-w-150px border-1 border text-center">Foto Sekretariat Pokja Desa</th>

                    </tr>
                </thead>
                <tbody>
                   @foreach ($village as $item)
                       <tr>
                            @php
                                $forumKel2 = $forumKel->where('id_village', $item->id)->first();
                            @endphp
                            <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                            <td class="border border-1 text-center">
                                @if (is_null($forumKel2))
                                    <a href="{{ route('pokja-desa.createSkPokjaDesa', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('pokja-desa.editSkPokjaDesa', [$forumKel2->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <button class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $forumKel2->id }}">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </button>
                                   
                                @endif
                                
                            </td>
                            @if (!is_null($forumKel2))
                                <div class="modal text-start fade" tabindex="-1" id="confirmDelete{{ $forumKel2->id }}">
                                    <form action="{{ route('pokja-desa.destroyPokjaDesa', $forumKel2->id) }}" method="POST">
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
                            @if ($forumKel2)
                                <td class="border-1 border">{{$forumKel2->f_village}}</td>
                                <td class="border-1 border">{{$forumKel2->no_sk}}</td>
                                <td class="border-1 border">{{$forumKel2->expired_sk}}</td>
                                <td class="border-1 border">{{ number_format($forumKel2->f_budget,0,',','.') }}</td>
                                <td class="border-1 border">{{$forumKel2->s_address}}</td>

                                @if (!is_null($forumKel2->path_sk_f))
                                <td class="border-1 border text-center">
                                    <a href="{{ asset('uploads/doc-pokja-desa/'.$forumKel2->path_sk_f) }}" target="_blank" class="btn btn-success btn-sm ">
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
                                    <a href="{{ asset('uploads/doc-pokja-desa/'.$forumKel2->path_plan_f) }}" target="_blank" class="btn btn-success btn-sm ">
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
                                    <a href="{{ asset('uploads/doc-pokja-desa/'.$forumKel2->path_budget) }}" target="_blank" class="btn btn-success btn-sm ">
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
                                    <a href="{{ asset('uploads/doc-pokja-desa/'.$forumKel2->path_s) }}" target="_blank" class="btn btn-success btn-sm ">
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
                                        <td class="border-1 border text-center" rowspan="{{ $activityCount }}">
                                            <a href="{{ route('pokja-desa.createActivityPokja', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
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
                                        <a href="{{ route('pokja-desa.editActivityPokja', [$item_v2->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
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
                                    <a href="{{ route('pokja-desa.createActivityPokja', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3">
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


   
@endsection

@section('script')
    <script>
        $("#tableSKPokjaDesa").DataTable({
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
        
        
    </script>
@endsection
