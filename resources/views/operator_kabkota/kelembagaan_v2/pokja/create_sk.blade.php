@extends('partials.index')
@section('heading')
    {{$village->name}}
@endsection
@section('page')
    Data Pokja Desa {{$village->name}}
@endsection
@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{route('pokja-desa.storeSKPokjaDesa', $category->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input SK Pokja Desa</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="id_village" class="form-label">Nama Kelurahan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Kecamatan"
                                required
                                oninvalid="this.setCustomValidity('Nama Kecamatan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$village->name}}"
                                readonly
                            >
                            <input name="id_village" id="id_village" value="{{$village->id}}" hidden>
                            @error('id_village')
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
                            <label for="name" class="form-label">Nama Pokja Desa</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Pokja Desa"
                                name="f_village"
                                required
                                oninvalid="this.setCustomValidity('Nama Pokja Desa tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('f_village')
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
                            <label for="name" class="form-label">NO SK Pokja Desa</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nomor SK"
                                name="no_sk"
                                required
                                oninvalid="this.setCustomValidity('Nomor SK tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('no_sk')
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
                            <label for="time" class="form-label">Masa Berlaku SK Pokja Desa</label>
                            <input type="text"
                                id="expired_sk"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Masa Berlaku"
                                name="expired_sk"
                                required
                                oninvalid="this.setCustomValidity('Masa Berlaku tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('expired_sk')
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
                            <label for="f_budget" class="form-label">Alokasi Anggaran Pokja Desa (Rp)</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Anggaran Pokja Desa"
                                name="f_budget"
                                id="f_budget"
                                required
                                oninvalid="this.setCustomValidity('Anggaran Pokja Desa tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                onkeyup="formatRupiah(this)"
                            >
                            @error('f_budget')
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
                            <label for="path_budget" class="form-label">Dokumen Anggaran Pokja Desa<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_budget" id="path_budget" accept=".pdf">
                            @error('path_budget')
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
                            <label for="path_sk_f" class="form-label">Dokumen SK Pokja Desa<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_sk_f" id="path_sk_f" accept=".pdf">
                            @error('path_sk_f')
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
                            <label for="path_plan_f" class="form-label">Dokumen Renja Pokja Desa<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_plan_f" id="path_plan_f" accept=".pdf">
                            @error('path_plan_f')
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
                            <label for="path_s" class="form-label">Foto Sekretariat Pokja Desa<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_s" id="path_s" accept=".pdf">
                            @error('path_s')
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
                            <label for="s_address" class="form-label">Alamat Sekretariat Pokja Desa</label>
                            <textarea 
                                name="s_address" 
                                id="s_address" 
                                cols="3" rows="3" 
                                class="form-control form-control-solid"
                                placeholder="Masukkan Alamat Sekretariat Pokja Desa"
                                oninvalid="this.setCustomValidity('Alamat Sekretariat Pokja Desa tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                required
                            ></textarea>
                            @error('s_address')
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
                <a href="{{route('pokja-desa.showPokjaDesa',[$category->id, $village->subdistrict_id])}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#expired_sk").flatpickr();
        function formatRupiah(input) {
            // Hapus format sebelumnya (titik/koma) dan sisakan hanya angka
            let value = input.value.replace(/[^,\d]/g, '');
            // Tambahkan pemisah ribuan dengan titik
            const rupiah = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = rupiah;
        }
        document.addEventListener('change', function (e) {
            if (e.target && e.target.type === 'file') {
                const file = e.target.files[0];
                const maxSize = 2 * 1024 * 1024; // 2 MB

                if (file && file.type !== 'application/pdf') {
                    Swal.fire({
                        icon: 'error',
                        title: 'File tidak valid',
                        text: 'Hanya file PDF yang diizinkan!',
                        confirmButtonText: 'Oke',
                    });
                    e.target.value = ''; // Reset input
                } else if (file && file.size > maxSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran file terlalu besar',
                        text: 'Ukuran maksimal file adalah 2 MB.',
                        confirmButtonText: 'Oke',
                    });
                    e.target.value = ''; // Reset input
                }
            }
        });
    </script>
@endsection