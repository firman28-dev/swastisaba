@extends('partials.index')
@section('heading')
    Pendanaan KabKota
@endsection
@section('page')
    Dokumen Pendanaan KabKota
@endsection


@section('content')
    @php
        $now = strtotime(now());
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
                <h3>
                    Daftar Dokumen Pendanaan KabKota
                </h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1 text-center p-3 align-middle">No.</th>
                            <th class="w-50 border border-1">Nama Dokumen</th>
                            <th class="border border-1 text-center">Dokumen Upload</th>
                            <th class="w-150px border border-1 text-center">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendanaan_kabkota as $data)
                            <tr>
                                <td class="border border-1 text-center p-3">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border border-1 p-3">{{ $data->name }}</td>
                                @php
                                    $relatedAnswerDoc = $answer_doc->where('id_pendanaan_kabkota', $data->id)->first();
                                @endphp
                                @if ($relatedAnswerDoc)
                                    <td class="border border-1 text-center">
                                        <div class="badge badge-light-success">Sudah upload</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        <a href="{{ asset('uploads/doc_pendanaan/'.$relatedAnswerDoc->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-eye"></i>
                                            </div>
                                        </a>
                                        <button 
                                            @if ($now >= $start && $now <= $end)
                                                class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $relatedAnswerDoc->id }}"
                                            @else
                                                class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" disabled
                                            @endif>
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-trash"></i>
                                            </div>
                                        </button>
                                        <div class="modal fade text-start" tabindex="-1" id="confirmDelete{{ $relatedAnswerDoc->id }}">
                                            <form action="{{ route('pendanaan-kabkota.destroy', $relatedAnswerDoc->id) }}" method="POST">
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
                                    <td class="border border-1 text-center">
                                        <div class="badge badge-light-danger">Belum upload</div>
                                    </td>
                                    <td class="border border-1 text-center">
                                        <button  
                                            @if ($now >= $start && $now <= $end)
                                                class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#createModal{{$data->id}}"
                                            @else
                                            class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" disabled
                                            @endif>
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-square-plus"></i>
                                            </div>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade text-start" tabindex="-1" id="createModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false">>
                                            <form action="{{route('pendanaan-kabkota.store', $data->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">
                                                                Input Dokumen Gambaran Umum
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input name="id_survey" value="{{session('selected_year')}}" hidden>
                                                            <div class="col-lg-12">
                                                                <div class="form-group w-100">
                                                                    <label for="name" class="form-label">Dokumen</label>
                                                                    <p class="text-danger">Dokumen berbentuk Pdf dan maksimal 2 MB</p>
                                                                    <input type="file" name="path" class="form-control form-control-solid rounded rounded-4" placeholder="File" accept=".pdf">
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
@endsection

@section('script')
    <script>
        $("#tableSKPD").DataTable({
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
    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 10 * 1024 * 1024; // 2 MB

            if (file && file.type !== 'application/pdf') {
                alert('File harus berformat PDF.');
                e.target.value = ''; // Reset input
            } else if (file && file.size > maxSize) {
                // alert('Ukuran file tidak boleh lebih dari 2 MB.');
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran file terlalu besar',
                    text: 'Ukuran maksimal file adalah 10 MB.',
                    confirmButtonText: 'Oke',
                });
                e.target.value = ''; // Reset input
            }
        });
    </script>
@endsection
