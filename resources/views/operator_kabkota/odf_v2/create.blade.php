@extends('partials.index')
@section('heading')
    Data ODF
@endsection
@section('page')
    Data ODF
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('data-odf.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data ODF</h3>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="sum_subdistricts" class="form-label">Jumlah Kecamatan</label>
                            <input type="number"
                                id="sum_subdistricts"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Jumlah Kecamatan"
                                required
                                oninvalid="this.setCustomValidity('Jumlah Kecamatan harus antara 0 dan 100.')"
                                oninput="this.setCustomValidity('')"
                                name="sum_subdistricts"
                                min="0"
                                max="100"
                                value="{{$sum_distirct}}"
                                readonly
                            >
                            @error('sum_subdistricts')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="sum_villages" class="form-label">Jumlah Kelurahan/Desa</label>
                            <input type="number"
                                id="sum_villages"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Jumlah Kelurahan/Desa"
                                required
                                oninvalid="this.setCustomValidity('Jumlah Kelurahan harus antara 0 dan 100.')"
                                oninput="this.setCustomValidity('')"
                                name="sum_villages"
                                min="1"
                                max="100"
                                value="{{$sum_village}}"
                                readonly
                            >
                            @error('sum_villages')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="s_villages_stop_babs" class="form-label">Jumlah Kelurahan/Desa Stop BABS</label>
                            <input type="number"
                                id="s_villages_stop_babs"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Jumlah Kelurahan/Desa Stop BABS"
                                required
                                oninput="this.setCustomValidity(''); calculatePercentage()"
                                oninvalid="this.setCustomValidity('Maksimal Kelurahan/Desa Stop BABS {{ $sum_village }}.')"
                                name="s_villages_stop_babs"
                                max="{{$sum_village}}"
                            >
                            @error('s_villages_stop_babs')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="p_villages_stop_babs" class="form-label">Pesentase Kelurahan/Desa Stop BABS (%)</label>
                            <input type="number"
                                id="p_villages_stop_babs"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Persentase Kelurahan/Desa Stop BABS"
                                required
                                oninput="calculatePercentage()"
                                oninvalid="this.setCustomValidity('Persentase Kelurahan/Desa Stop BABS harus antara 1 dan 100.')"
                                name="p_villages_stop_babs"
                                readonly

                            >
                            @error('p_villages_stop_babs')
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

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('data-odf.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        const sum_villages = {{$sum_village}};
        // console.log(sum_villages);
        function calculatePercentage() {
            // Ambil elemen input jumlah kelurahan dan persentase
            const capaianInput = document.getElementById('s_villages_stop_babs');
            const persentaseInput = document.getElementById('p_villages_stop_babs');

            // Ambil nilai jumlah kelurahan dan total kelurahan
            const capaianValue = parseFloat(capaianInput.value) || 0; // Default ke 0 jika kosong
            const totalKelurahan = sum_villages; // Ganti dengan jumlah kelurahan yang sesuai, atau ambil dari API

            // Validasi agar tidak ada pembagian nol
            if (totalKelurahan > 0) {
                const percentage = (capaianValue / sum_villages) * 100;
                persentaseInput.value = percentage.toFixed(2); // Format angka ke 2 desimal
            } else {
                persentaseInput.value = ''; // Kosongkan jika totalKelurahan tidak valid
            }
        }
     

    </script>
@endsection
