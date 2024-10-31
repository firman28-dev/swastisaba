@extends('partials.index')
@section('heading')
    Sub Dokumen Provinsi
@endsection
@section('page')
    Data Sub Dokumen Provinsi
@endsection


@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('sub-doc-prov.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Sub Dokumen Provinsi</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="id_survey" class="form-label">Tahun</label>
                            @php
                                $selected_year = Session::get('selected_year');
                                $date = \App\Models\Trans_Survey::where('id', $selected_year)->first()
                            @endphp
                            <input type="text" id="id_survey"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Tahun"
                                required
                                oninvalid="this.setCustomValidity('Tahun tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$date->trans_date ?? ''}}"
                                readonly
                            >
                            <input name="id_survey" hidden value="{{session('selected_year') ?? ''}}">
                            @error('id_survey')
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
                            <label for="id_c_doc_prov" class="form-label">Nama Kategori Dokumen</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Kategori tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$category->name}}"
                            >
                            <input hidden name="id_c_doc_prov" value="{{$category->id}}">
                            @error('id_c_doc_prov')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <div id="dynamic-input-fields">
                    <label for="opsi" class="form-label">Sub Kategori Dokumen Provinsi<span class="required"></span></label>
                    <div class="row mb-3" id="field-1">
                        <div class="col-md-10">
                            <input type="text" name="name[]" class="form-control form-control-solid rounded rounded-4" placeholder="Sub Kategori" required>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-3" id="add-field">Tambah Opsi</button>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('showSubDoc',$category->id)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        let counter = 1;
        document.getElementById('add-field').addEventListener('click', function () {
            counter++;
            
            // Create a new div for input fields
            const newField = document.createElement('div');
            newField.classList.add('row', 'mb-3');
            newField.id = 'field-' + counter;

            // Add HTML for Opsi and Score inputs
            newField.innerHTML = `
                <div class="col-md-10">
                    <input type="text" name="name[]" class="form-control form-control-solid rounded rounded-4" placeholder="Sub Kategori" required>
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
