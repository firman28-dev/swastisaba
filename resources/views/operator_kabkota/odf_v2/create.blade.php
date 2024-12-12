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
                                oninvalid="this.setCustomValidity('Kelurahan/Desa Stop BABS harus antara 0 dan 100.')"
                                oninput="this.setCustomValidity('')"
                                name="s_villages_stop_babs"
                                min="0"
                                max="100"
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
                                oninvalid="this.setCustomValidity('Persentase Kelurahan/Desa Stop BABS harus antara 1 dan 100.')"
                                oninput="this.setCustomValidity('')"
                                name="p_villages_stop_babs"
                                min="1"
                                max="100"
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
        $("#id_proposal").select2();
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
