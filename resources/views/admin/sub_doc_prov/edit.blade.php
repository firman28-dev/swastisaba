@extends('partials.index')
@section('heading')
    Sub Dokumen Provins
@endsection
@section('page')
    Data Sub Dokumen Provins
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('sub-doc-prov.update',$sub->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Sub Dokumen Provinsi</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_category" class="form-label">Kategori</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori"
                                required
                                oninvalid="this.setCustomValidity('Pertanyaan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                readonly
                                value="{{$sub->_c_doc_prov->name}}"
                            >
                            <input hidden name="id_c_doc_prov" value="{{$sub->id_c_doc_prov}}">
                            @error('id_c_doc_prov')
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
                            <label for="id_category" class="form-label">Sub Kategori Dokumen</label>
                            <textarea name="name" id="" cols="2" rows="2" class="form-control form-control-solid">{{$sub->name}}</textarea>
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
                <a href="{{route('showSubDoc',$sub->id_c_doc_prov)}}" class="btn btn-sm btn-secondary">
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
