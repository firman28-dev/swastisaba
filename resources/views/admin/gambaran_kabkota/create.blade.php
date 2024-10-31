@extends('partials.index')
@section('heading')
Gambaran Umum KabKota
@endsection
@section('page')
    Data Gambaran Umum KabKota
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('gambaran-kabkota.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Gambaran Umum KabKota</h3>
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
                    <div id="dynamic-input-fields">
                        <div class="row">
                            <div class="col-md-5 mb-4">
                                <div class="form-group w-100">
                                    <label for="name" class="form-label">Nama Gambaran Umum</label>
                                    <textarea id="name" name="name[]" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Nama Gambaran Umum"></textarea>
                                    @error('name')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 mb-4">
                                <div class="form-group w-100">
                                    <label for="ket" class="form-label">Keterangan</label>
                                    <textarea id="ket" name="ket[]" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Keteragan Gambaran Umum"></textarea>
                                    @error('ket')
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
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm mt-3 w-50px btn-icon" id="add-field">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('gambaran-kabkota.index')}}" class="btn btn-sm btn-secondary">
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
                <div class="col-md-5">
                    <textarea id="name" name="name[]" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Nama Gambaran Umum"></textarea>
                </div>
                <div class="col-md-5">
                    <textarea id="ket" name="ket[]" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Keteragan Gambaran Umum"></textarea>
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
