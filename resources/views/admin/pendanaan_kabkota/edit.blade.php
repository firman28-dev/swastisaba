@extends('partials.index')
@section('heading')
Pendanaan KabKota
@endsection
@section('page')
    Data Pendanaan KabKota
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('pendanaan-kabkota.update', $pendanaan_kabkota->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Pendanaan KabKota</h3>
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
                            <label for="name" class="form-label">Nama Pendananaan</label>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Nama Pendanaan"
                                required
                                oninvalid="this.setCustomValidity('Nama Pendanaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$pendanaan_kabkota->name}}"
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
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('pendanaan-kabkota.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
   
@endsection
