@extends('partials.index')
@section('heading')
    Kategori
@endsection
@section('page')
    Data Kategori
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('doc-g-data.update',$doc->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Dokumen Data Umum</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Nama Dokumen</label>
                            <input type="text" 
                                id="name" 
                                name="name"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Dokumen"
                                required
                                oninvalid="this.setCustomValidity('Nama Dokumen tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$doc->name}}"
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
                        <div class="form-group w-100">
                            <label for="note" class="form-label">Keterangan Dokumen Dokumen</label>
                            <textarea name="note" class="form-control form-control-solid rounded rounded-4" rows="3" >{{$doc->note}}</textarea>
                            @error('note')
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
                <a href="{{route('category.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

