@extends('partials.index')
@section('heading')
    Pertanyaan Kelembagaan
@endsection
@section('page')
    Data Pertanyaan Kelembagaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('q-kelembagaan-v2.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Pertanyaan Kelembagaan</h3>
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
                            <label for="id_category" class="form-label">Kategori Kelembagaan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$c_kelembagaan_v2->name}}"
                            >
                            <input hidden name="id_c_kelembagaan_v2" value="{{$c_kelembagaan_v2->id}}">
                            @error('id_c_kelembagaan_v2')
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
                    <div class="row">
                        <div class="col-lg-5 mb-4">
                            <div class="form-group">
                                <label for="indikator" class="form-label">Indikator</label>
                                <input type="text" id="indikator" name="indikator[]"
                                    class="form-control form-control-solid rounded rounded-4"
                                    placeholder="Masukkan Nama indikator"
                                    required
                                    oninvalid="this.setCustomValidity('Nama indikator tidak boleh kosong.')"
                                    oninput="this.setCustomValidity('')"
                                >
                                @error('indikator')
                                    <div class="is-invalid">
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-5 mb-4">
                            <div class="form-group">
                                <label for="s_data" class="form-label">Sumber Data</label>
                                <input type="text" id="s_data" name="s_data[]"
                                    class="form-control form-control-solid rounded rounded-4"
                                    placeholder="Masukkan Sumber data"
                                    required
                                    oninvalid="this.setCustomValidity('Sumber data tidak boleh kosong.')"
                                    oninput="this.setCustomValidity('')"
                                >
                                @error('s_data')
                                    <div class="is-invalid">
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-5 mb-4">
                            <div class="form-group">
                                <label for="d_operational" class="form-label">Definisi Operasional</label>
                                <textarea name="d_operational[]" id="d_operational" class="form-control form-control-solid rounded rounded-4" rows="3" cols="3" placeholder="Definisi Operasional"></textarea>
                                
                                @error('d_operational')
                                    <div class="is-invalid">
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-5 mb-4">
                            <div class="form-group">
                                <label for="data_dukung" class="form-label">Data Pendukung</label>
                                <textarea name="data_dukung[]" id="data_dukung" class="form-control form-control-solid rounded rounded-4" rows="3" cols="3" placeholder="Data Pendukung"></textarea>
                                
                                @error('data_dukung')
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
                <button type="button" class="btn btn-primary btn-sm mt-3" id="add-field">Tambah Indikator</button>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('showQKelembagaanNew',$c_kelembagaan_v2->id)}}" class="btn btn-sm btn-secondary">
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
            newField.classList.add('row', 'align-items-end', 'mb-3');
            newField.id = 'field-' + counter;

            // Add HTML for Opsi and Score inputs
            newField.innerHTML = `
                <div class="col-lg-5 mb-4">
                    <div class="form-group">
                        <label for="indikator" class="form-label">Indikator</label>
                        <input type="text" id="indikator" name="indikator[]"
                            class="form-control form-control-solid rounded rounded-4"
                            placeholder="Masukkan Nama indikator"
                            required
                            oninvalid="this.setCustomValidity('Nama indikator tidak boleh kosong.')"
                            oninput="this.setCustomValidity('')"
                        >
                        @error('indikator')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="form-group">
                        <label for="s_data" class="form-label">Sumber Data</label>
                        <input type="text" id="s_data" name="s_data[]"
                            class="form-control form-control-solid rounded rounded-4"
                            placeholder="Masukkan Sumber data"
                            required
                            oninvalid="this.setCustomValidity('Sumber data tidak boleh kosong.')"
                            oninput="this.setCustomValidity('')"
                        >
                        @error('s_data')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="d_operational" class="form-label">Definisi Operasional</label>
                        <textarea name="d_operational[]" id="d_operational" class="form-control form-control-solid rounded rounded-4" rows="3" cols="3" placeholder="Definisi Operasional"></textarea>
                        
                        @error('d_operational')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="data_dukung" class="form-label">Data Pendukung</label>
                        <textarea name="data_dukung[]" id="data_dukung" class="form-control form-control-solid rounded rounded-4" rows="3" cols="3" placeholder="Data Pendukung"></textarea>
                        
                        @error('data_dukung')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-2">
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
