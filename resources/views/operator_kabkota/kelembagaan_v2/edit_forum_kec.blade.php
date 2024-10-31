@extends('partials.index')
@section('heading')
    Forum Kecamatan
@endsection
@section('page')
    Data Forum Kecamatan
@endsection
@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('kelembagaan-v2.updateForumKec' , $activity->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Forum Kecamatan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Nama Kecamatan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Kecamatan"
                                name="district"
                                required
                                oninvalid="this.setCustomValidity('Nama Kecamatan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$activity->district}}"
                            >
                            @error('district')
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
                            <label for="name" class="form-label">Forum Kecamatan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Forum Kecamatann"
                                name="f_district"
                                required
                                oninvalid="this.setCustomValidity('Forum Kecamatann tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$activity->f_district}}"

                            >
                            @error('f_district')
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
                            <label for="name" class="form-label">NO SK Forum Kec</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nomor SK"
                                name="no_sk"
                                required
                                oninvalid="this.setCustomValidity('Nomor SK tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$activity->no_sk}}"

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
                            <label for="time" class="form-label">Masa Berlaku SK Forum Kec</label>
                            <input type="text"
                                id="expired_sk"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Masa Berlaku"
                                name="expired_sk"
                                required
                                oninvalid="this.setCustomValidity('Masa Berlaku tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$activity->expired_sk}}"

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
                            <label for="f_budget" class="form-label">Alokasi Anggaran Forum Kec (Rp)</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Anggaran Forum"
                                name="f_budget"
                                id="f_budget"
                                required
                                oninvalid="this.setCustomValidity('Anggaran Forum tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                onkeyup="formatRupiah(this)"
                                value="{{$activity->f_budget}}"

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
                            <label for="path_budget" class="form-label">Dokumen Anggaran Forum Kec<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_budget" id="path_budget">
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
                            <label for="path_sk_f" class="form-label">Dokumen SK Forum Kec<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_sk_f" id="path_sk_f">
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
                            <label for="path_plan_f" class="form-label">Dokumen Renja Forum Kec<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_plan_f" id="path_plan_f">
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
                            <label for="path_s" class="form-label">Foto Sekretariat Forum Kec<span class="text-danger"> * pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path_s" id="path_s">
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
                            <label for="s_address" class="form-label">Alamat Sekretariat Forum Kec</label>
                            <textarea 
                                name="s_address" 
                                id="s_address" 
                                cols="3" rows="3" 
                                class="form-control form-control-solid"
                                placeholder="Masukkan Alamat Sekretariat Forum Kecamatan"
                                oninvalid="this.setCustomValidity('Alamat Sekretariat Forum tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >{{$activity->s_address}}</textarea>
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
                <a href="{{route('kelembagaan-v2.show', $activity->id_c_kelembagaan)}}" class="btn btn-sm btn-secondary">
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
    </script>
@endsection