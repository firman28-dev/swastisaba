@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
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
                            <label for="id_category" class="form-label">Kategori</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Kategory tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$category->name}}"
                            >
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
                    <div class="col-lg-12 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Pertanyaan</label>
                            <textarea name="name" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Pertanyaan"></textarea>
                            {{-- <textarea name="name" id="text-a" id="name" class="form-control form-control-solid rounded rounded-4"
                                required oninvalid="this.setCustomValidity('Pertanyaan data tidak boleh kosong.')" oninput="this.setCustomValidity('')">
                            </textarea> --}}
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="s_data" class="form-label">Ketersediaan Data</label>
                            <textarea name="s_data" class="form-control form-control-solid rounded rounded-4" cols="30" rows="10" placeholder="Ketersediaan data dukung"></textarea>
                            {{-- <textarea name="s_data" id="s_data" cols="30" rows="10" class="form-control form-control-solid rounded rounded-4"
                                required="required"
                                oninvalid="this.setCustomValidity('Ketersediaan data tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')">
                            </textarea> --}}
                            @error('s_data')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Ketersediaan data tidak boleh kosong
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="d_operational" class="form-label">Definisi Operasional</label>
                            <textarea name="d_operational" class="form-control form-control-solid rounded rounded-4" cols="30" rows="10" placeholder="Definisi operasional"></textarea>

                            @error('d_operational')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Definisi tidak boleh kosong
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
                <a href="{{route('showQuestionV1', $category->id)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#id_category").select2();
        const textarea = document.getElementById('text-a');
        textarea.addEventListener('input', function () {
            // Menghilangkan spasi di awal teks saat pengguna mengetik
            this.value = this.value.replace(/^\s+/, '');
        });
    </script>
@endsection
