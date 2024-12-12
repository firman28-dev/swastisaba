@extends('partials.index')
@section('heading')
Data ODF
@endsection
@section('page')
Data ODF 
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

    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Kelengkapan ODF</h3>
            </div>
           
            @if($odf && $odf->id)
                @if ($now >= $start && $now <= $end)
                    <a href="{{ route('data-odf.edit', $odf->id) }}" class="btn btn-primary btn-sm align-self-center">
                        Edit Data
                    </a>
                @else
                    <a href="{{ route('data-odf.edit', $odf->id) }}" class="btn btn-primary btn-sm align-self-center disabled" >
                        Edit Data
                    </a>
                @endif
            @else
                @if ($now >= $start && $now <= $end)
                    <a href="{{ route('data-odf.create') }}" class="btn btn-primary btn-sm align-self-center" >
                        Tambah Data
                    </a>
                @else
                    <a href="{{ route('data-odf.create') }}" class="btn btn-primary btn-sm align-self-center disabled">
                        Tambah Data
                    </a>
                @endif
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Jumlah Kecamatan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold fs-6 text-gray-800">{{$odf->sum_subdistricts ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Jumlah Kelurahan/Desa</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6" >{{$odf->sum_villages ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Jumlah Kelurahan/Desa Stop BABS</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{$odf->s_villages_stop_babs ?? 'Belum ada'}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Pesentase Kelurahan/Desa Stop BABS (%)</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $odf ? ($odf->p_villages_stop_babs ?? 'Belum ada') . ($odf->p_villages_stop_babs ? '%' : '') : 'Belum ada' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
