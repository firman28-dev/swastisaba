@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('questions.update',$questions->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Pertanyaan</h3>
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
                                oninvalid="this.setCustomValidity('Kategory tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$questions->_category->name}}"
                            >
                            <input hidden name="id_category" value="{{$questions->id_category}}">
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
                            <textarea name="name" class="form-control form-control-solid rounded rounded-4" rows="2" >{{$questions->name}}</textarea>
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
                            <textarea name="s_data" class="form-control form-control-solid rounded rounded-4" cols="30" rows="10" >{{$questions->s_data}}</textarea>
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
                            <textarea name="d_operational" class="form-control form-control-solid rounded rounded-4 custom-textarea" cols="30" rows="10">{{$questions->d_operational}}</textarea>
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
                <a href="{{route('showQuestionV1', $questions->id_category)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#id_category").select2();
    </script>
@endsection
