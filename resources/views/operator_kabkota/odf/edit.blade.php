@extends('partials.index')
@section('heading')
    Data ODF
@endsection
@section('page')
    Data ODF
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('odf.updateKabKota',$transOdf->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data ODF</h3>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="percentage" class="form-label">Pesentase ODF (%)</label>
                            <input type="number"
                                id="percentage"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan persentase odf"
                                required
                                oninvalid="this.setCustomValidity('Persentase ODF harus antara 1 dan 100.')"
                                oninput="this.setCustomValidity('')"
                                name="percentage"
                                min="1"
                                max="100"
                                value="{{$transOdf->percentage}}"
                            >
                            @error('percentage')
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
                            <label for="id_proposal" class="form-label">Usulan ODF</label>
                            <select 
                                name="id_proposal" 
                                id="id_proposal"
                                class="form-select form-select-solid rounded rounded-4" 
                                required
                                oninvalid="this.setCustomValidity('Usulan ODF tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                                <option value="" disabled {{ is_null($transOdf->id_proposal) ? 'selected' : '' }}>Pilih Usulan ODF</option>
                                @foreach($proposals as $proposal)
                                    <option value="{{ $proposal->id }}" {{ $transOdf->id_proposal == $proposal->id ? 'selected' : '' }}>
                                        {{ $proposal->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="path" class="form-label">Dokumen ODF<span class="required"></span><span class="text-danger">Maks 10MB | PDF</span> </label>
                            <input type="file" id="path" name="path" class="form-control form-control-solid rounded rounded-4" placeholder="File" accept=".pdf">
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
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('odf.index')}}" class="btn btn-sm btn-secondary">
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
