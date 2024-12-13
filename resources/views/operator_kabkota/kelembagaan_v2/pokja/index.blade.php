@extends('partials.index')
@section('heading')
    Kecamatan {{$subdistrict->name}}
@endsection
@section('page')
    Data Kecamatan {{$subdistrict->name}}
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
                            <th class="min-w-60px text-center border-1 border">ID</th>
                            <th class="min-w-60px text-center border-1 border">SubID</th>
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
                                <td class="border-1 border text-center">{{ $item->id }}</td>
                                <td class="border-1 border text-center">{{ $item->subdistrict_id }}</td>


                                <td class="border border-1 text-center">
                                    @if (is_null($forumKel2))
                                        <a href="{{ route('pokja-desa.createSkPokjaDesa', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('pokja-desa.editSkPokjaDesa', [$forumKel2->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                        <button 
                                            @if ($now >= $start && $now <= $end)
                                                class="btn btn-icon btn-danger w-35px h-35px mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $forumKel2->id }}"
                                            @else
                                                class="btn btn-icon btn-danger w-35px h-35px mb-3" disabled
                                            @endif>
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
                                    <td class="border-1 border">{{ \Carbon\Carbon::parse($forumKel2->expired_sk)->format('d-F-Y') ?? '-' }}</td>
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
                                                <a href="{{ route('pokja-desa.createActivityPokja', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
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
                                            <a href="{{ route('pokja-desa.editActivityPokja', [$item_v2->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
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
                                        <a href="{{ route('pokja-desa.createActivityPokja', [$category->id, $item->id]) }}" class="btn btn-icon btn-primary w-35px h-35px mb-3 {{ $now >= $start && $now <= $end ? '' : 'disabled' }}">
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
