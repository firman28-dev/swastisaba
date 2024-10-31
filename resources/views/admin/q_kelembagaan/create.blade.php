@extends('partials.index')
@section('heading')
    Pertanyaan Kelembagaan
@endsection
@section('page')
    Data Pertanyaan Kelembagaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('q-kelembagaan.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Pertanyaan Kelembagaan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="form-group">
                            <label for="id_category" class="form-label">Kategori Kelembagaan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$c_kelembagaan->name}}"
                            >
                            <input hidden name="id_c_kelembagaan" value="{{$c_kelembagaan->id}}">
                            @error('id_category')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Pertanyaan tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <div id="dynamic-input-fields">
                    <label for="opsi" class="form-label">Opsi<span class="required"></span></label>
                    <div class="row mb-3" id="field-1">
                        <div class="col-md-5">
                            <input type="text" name="question[]" class="form-control form-control-solid rounded rounded-4" placeholder="Pertanyaan" required>
                        </div>
                        <div class="col-md-5">
                            <textarea name="opsi[]" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Opsi" required></textarea>
                            {{-- <input type="text" name="opsi[]" class="form-control form-control-solid rounded rounded-4" placeholder="Opsi" required> --}}
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-3" id="add-field">Tambah Opsi</button>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('showQKelembagaan',$c_kelembagaan->id)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        let counter = 0;
        document.getElementById('add-field').addEventListener('click', function () {
            counter++;

            // Create a new div for input fields
            const newField = document.createElement('div');
            newField.classList.add('row', 'mb-3');
            newField.id = 'field-' + counter;

            // Add HTML for Opsi and Score inputs
            newField.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="question[]" class="form-control form-control-solid rounded rounded-4" placeholder="Pertanyaan" required>
                </div>
                <div class="col-md-5">
                    <textarea name="opsi[]" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Opsi" required></textarea>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field btn-sm" data-id="${counter}">Hapus</button>
                </div>
            `;

            // Append new input fields to the container
            document.getElementById('dynamic-input-fields').appendChild(newField);
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-field')) {
                const fieldId = e.target.getAttribute('data-id');
                document.getElementById('field-' + fieldId).remove();
            }
        });
    </script>
@endsection
