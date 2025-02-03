@extends('partials.index')
@section('heading')
    Opsi Pertanyaan
@endsection
@section('page')
    Data Opsi Pertanyaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('q-option.update',$q_option->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Opsi Pertanyaan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="form-group">
                            <label for="id_category" class="form-label">Pertanyaan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$q_option->_question->name}}"
                            >
                            <input hidden name="id_question" value="{{$q_option->id_question}}">
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
                    <label for="opsi" class="form-label">Opsi</label>
                    <div class="row mb-3" id="field-1">
                        <div class="col-md-5">
                            <textarea name="name" class="form-control form-control-solid" required id="name" placeholder="Opsi">{{$q_option->name}}</textarea>
                            {{-- <input type="text" name="name" class="form-control form-control-solid" placeholder="Opsi" required value="{{$q_option->name}}"> --}}
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="score" class="form-control form-control-solid" placeholder="Score" required value="{{$q_option->score}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('showQuestionOpt',$q_option->id_question)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        
    </script>
@endsection
