@extends('partials.index')
@section('heading')
Kegiatan Pokja Desa
@endsection
@section('page')
    Data Kegiatan Pokja Desa
@endsection
@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{route('pokja-desa.storeActivityPokja', $category->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Kegiatan Pokja Desa</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Nama Kelurahan/Desa</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Kegiatan"
                                oninvalid="this.setCustomValidity('Nama Kegiatan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$village->name}}"
                                readonly
                            >
                            <input name="id_kode" id="id_kode" value="{{$village->id}}" hidden>
                            @error('id_kode')
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
                            <label for="name" class="form-label">Nama Kegiatan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Kegiatan"
                                name="name"
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
                            <label for="number" class="form-label">Jumlah Peserta</label>
                            <input type="number"
                                id="participant"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Jumlah Peserta"
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
                                placeholder="Masukkan Keterangan"
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
        $("#time").flatpickr();
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 4 * 1024 * 1024; // 2 MB

            if (file && file.type !== 'application/pdf') {
                alert('File harus berformat PDF.');
                e.target.value = ''; // Reset input
            } else if (file && file.size > maxSize) {
                // alert('Ukuran file tidak boleh lebih dari 2 MB.');
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran file terlalu besar',
                    text: 'Ukuran maksimal file adalah 4 MB.',
                    confirmButtonText: 'Oke',
                });
                e.target.value = ''; // Reset input
            }
        });
    </script>
@endsection
