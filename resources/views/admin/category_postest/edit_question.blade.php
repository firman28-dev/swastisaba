@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('category-postest.updateQuestion', $question->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Input Data Pertanyaan</h3>
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
                            <input type="text" id="id_survey" class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Tahun" required
                                oninvalid="this.setCustomValidity('Tahun tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')" value="{{$date->trans_date ?? ''}}" readonly>
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
                            <label for="id_category" class="form-label">Kategori</label>
                            <input type="text" class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori" required
                                oninvalid="this.setCustomValidity('Kategory tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')" readonly value="{{$category->name}}">
                            <input hidden name="id_category" value="{{$category->id}}">
                            @error('id_category')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Kategori tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <label class="w-100 form-label">Pertanyaan</label>
                        <textarea id="question" name="question" class="form-control form-control-solid editor"
                            rows="10">{!! old('question', $question->question ?? '') !!}</textarea>
                        @error('question')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="w-100 form-label">Opsi A</label>
                        <textarea id="option_a" name="option_a" class="form-control form-control-solid editor"
                            rows="3">{!! old('option_a', $question->opt_a ?? '') !!}</textarea>
                        @error('option_a')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="w-100 form-label">Opsi B</label>
                        <textarea id="option_b" name="option_b" class="form-control form-control-solid editor"
                            rows="3">{!! old('option_b', $question->opt_b ?? '') !!}</textarea>
                        @error('option_b')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="w-100 form-label">Opsi C</label>
                        <textarea id="option_c" name="option_c" class="form-control form-control-solid editor"
                            rows="3">{!! old('option_c', $question->opt_c ?? '') !!}</textarea>
                        @error('option_c')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="w-100 form-label">Opsi D</label>
                        <textarea id="option_d" name="option_d" class="form-control form-control-solid editor"
                            rows="3">{!! old('option_d', $question->opt_d ?? '') !!}</textarea>
                        @error('option_d')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="w-100 form-label">Opsi Yang Benar</label>
                        <select id="opt_correct" name="opt_correct" class="form-select form-select-solid rounded rounded-4"
                            required autocomplete="off">
                            <option value="" disabled>Pilih Jawaban</option>
                            <option value="A" {{ old('opt_correct', $question->opt_correct ?? '') == 'A' ? 'selected' : '' }}>
                                A</option>
                            <option value="B" {{ old('opt_correct', $question->opt_correct ?? '') == 'B' ? 'selected' : '' }}>
                                B</option>
                            <option value="C" {{ old('opt_correct', $question->opt_correct ?? '') == 'C' ? 'selected' : '' }}>
                                C</option>
                            <option value="D" {{ old('opt_correct', $question->opt_correct ?? '') == 'D' ? 'selected' : '' }}>
                                D</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{ route('category-postest.show', $category->id) }}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>

@endsection

@section('script')
    <script src="{{ asset('tinymce/tinymce/tinymce.min.js') }}"></script>
    <script>
        $("#opt_correct").select2();

        const file_upload_handler = (callback, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');

            if (meta.filetype === 'file') {
                input.setAttribute('accept', '.pdf'); // hanya PDF
            } else if (meta.filetype === 'image') {
                input.setAttribute('accept', 'image/*');
            }

            input.onchange = function () {
                const file = this.files[0];
                const formData = new FormData();
                formData.append('file', file);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/upload-file-question');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                xhr.onload = () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const json = JSON.parse(xhr.responseText);
                        // Menambahkan link ke PDF
                        callback(json.location, { text: file.name });
                    } else {
                        alert('Upload gagal: ' + xhr.status);
                    }
                };

                xhr.send(formData);
            };

            input.click();
        };

        tinymce.init({
            selector: '.editor',
            license_key: 'gpl',
            plugins: [
                "image",
            ],
            toolbar: "undo redo | link image | styles | bold italic underline strikethrough | align | bullist numlist | code",
            file_picker_types: 'file image',
            file_picker_callback: file_upload_handler,
            images_file_types: 'jpg,svg,webp,png,jpeg',
            // images_upload_handler: example_image_upload_handler,
            relative_urls: false,
            convert_urls: false,

        });
    </script>
@endsection