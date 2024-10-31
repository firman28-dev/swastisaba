@extends('partials.index')
@section('heading')
    Opsi Jawaban
@endsection
@section('page')
    Data Opsi Jawaban
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('q-opt-kelembagaan.update', $q_option_kelembagaan->id) }}" method="POST">
            @csrf
            @method('patch')
            <div class="card-header">
                <h3 class="card-title">Edit Data Opsi Jawaban</h3>
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
                            <label for="id_q_kelembagaan" class="form-label">Indikator</label>
                            <input type="text"
                                id="id_q_kelembagaan"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$q_option_kelembagaan->_question->indikator}}"
                            >
                            {{-- <input hidden name="id_q_kelembagaan" value="{{$question_kelembagaan->id}}"> --}}
                            @error('id_q_kelembagaan')
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
                            <label for="name" class="form-label">Opsi </label>
                            <input type="text"
                                id="id_q_kelembagaan"
                                name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Opsi Jawaban"
                                required
                                oninvalid="this.setCustomValidity('Opsi Jawaban tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$q_option_kelembagaan->name}}"
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
                        <div class="form-group">
                            <label for="name" class="form-label">Score</label>
                            <input type="number"
                                name="score"
                                id="score"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Score"
                                required
                                oninvalid="this.setCustomValidity('Score tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$q_option_kelembagaan->score}}"
                            >
                            @error('score')
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
                <a href="{{route('q-opt-kelembagaan.index',$q_option_kelembagaan->id_q_kelembagaan)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
   
@endsection
