@extends('partials.index')
@section('heading')
    Data Pendukung Pertanyaan
@endsection
@section('page')
    Data Pendukung Pertanyaan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('doc-question.update',$doc->id) }}" method="POST">
            @csrf
            @method('patch')
            <div class="card-header">
                <h3 class="card-title">Edit Data Dukung Pertanyaan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_question" class="form-label">Pertanyaan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                id="id_question"
                                value="{{$doc->_question->name}}"
                            >
                            <input hidden name="id_question" value="{{$doc->id_question}}">
                            @error('id_question')
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
                            <label for="name" class="form-label">Pertanyaan</label>
                            <textarea name="name" id="" cols="2" rows="2" 
                                id="name"
                                class="form-control form-control-solid rounded"
                                oninvalid="this.setCustomValidity('nama data dukung tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')">{{$doc->name}}</textarea>
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
                            <label for="ket" class="form-label">Keterangan</label>
                            <textarea name="ket" id="" cols="2" rows="5" 
                                id="ket"
                                class="form-control form-control-solid rounded"
                                oninvalid="this.setCustomValidity('keterangan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')">{{$doc->ket}}</textarea>
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

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('doc-question.index',$doc->id_question)}}" class="btn btn-sm btn-secondary">
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
