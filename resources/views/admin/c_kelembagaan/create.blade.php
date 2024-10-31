@extends('partials.index')
@section('heading')
    Kategori Kelembagaan
@endsection
@section('page')
    Data Kategori Kelembagaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('c-kelembagaan.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Data Kategori Kelembagaan</h3>
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
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Kategori Kelembagaan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Kategori Kelembagaan"
                                name="name"
                                required
                                oninvalid="this.setCustomValidity('Kategori Kelembagaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                            >
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Nama tidak boleh kosong
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
                <a href="{{route('c-kelembagaan.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#id_level").select2();
    </script>
@endsection
