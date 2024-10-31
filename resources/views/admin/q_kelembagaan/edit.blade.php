@extends('partials.index')
@section('heading')
    Pertanyaan Kelembagaan
@endsection
@section('page')
    Data Pertanyaan Kelembagaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('q-kelembagaan.update',$q_kelembagaan->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Pertanyaan Kelembagaan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="form-group">
                            <label for="id_category" class="form-label">Kategori</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$q_kelembagaan->_c_kelembagaan->name}}"
                            >
                            <input hidden name="id_c_kelembagaan" value="{{$q_kelembagaan->id_c_kelembagaan}}">
                            @error('id_category')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        Categori Kelembagaan tidak boleh kosong
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
                            <input type="text" name="question" class="form-control form-control-solid" placeholder="Opsi" required value="{{$q_kelembagaan->question}}">
                        </div>
                        <div class="col-md-5">
                            <textarea name="opsi" class="form-control form-control-solid rounded rounded-4" rows="2" >{{$q_kelembagaan->opsi}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('showQKelembagaan',$q_kelembagaan->id_c_kelembagaan)}}" class="btn btn-sm btn-secondary">
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
