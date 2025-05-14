@extends('partials.index')
@section('heading')
    {{$district->name}}
@endsection
@section('page')
    Data Tatanan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Berita Acara Pertatanan</h3>
            </div>
        </div>
        <form action="{{ route('v-prov.storeBAPertatanan')}}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row gap-3">
                <div class="col-12">
                    <div class="form-group w-100">
                        <label for="achievement" class="form-label">Tahun</label>
                        <input type="text" value="{{ $date->trans_date }}"  readonly class="form-control form-control-solid rounded rounded-4">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group w-100">
                        <label for="achievement" class="form-label">Nama Kab/Kota</label>
                        <input type="text" value="{{ $district->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group w-100">
                        <label for="achievement" class="form-label">Nama Tatanan</label>
                        <input type="text" value="{{ $category->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group w-100">
                        <label for="achievement" class="form-label">Nama Penanggungjawab Kab/Kota</label>
                        <input type="text" 
                            required 
                            class="form-control form-control-solid rounded rounded-4" 
                            id="pembahas" 
                            name="pembahas" 
                            placeholder="Nama"
                            value="{{$ba_pertatanan->nama_pj_kabkota ?? ''}}"
                        >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group w-100">
                        <label for="achievement" class="form-label">Jabatan Penanggungjawab Kab/Kota</label>
                        <input type="text"  
                        required 
                        class="form-control form-control-solid rounded rounded-4" 
                        id="jabatan" 
                        name="jabatan" 
                        placeholder="Jabatan"
                        value="{{$ba_pertatanan->jb_pj_kabkota ?? ''}}"
                    >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group w-100">
                        <label for="achievement" class="form-label">Tim Verifikasi Provinsi</label>
                        <input type="text" 
                        required 
                        class="form-control form-control-solid rounded rounded-4" 
                        id="operator" 
                        name="operator" 
                        placeholder="Nama"
                        value="{{$ba_pertatanan->tim_verifikasi ?? ''}}"
                    >
                    </div>
                </div>
            </div>
            <input type="hidden" name="tahun" value="{{ $date->id }}">
            <input type="hidden" name="kota" value="{{ $district->id}}">
            <input type="hidden" name="category" value="{{ $category->id}}">

        </div>
        <div class="card-footer">
           <a href="{{ route('v-prov.showCategory', ['id' => $category->id, 'id_zona' => $district->id])}}">
                <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>Kembali
                </button>
            </a>
            <button type="submit" class="btn btn-primary  btn-sm">Simpan</button>
        </div>
        </form>
        
    </div>
@endsection

@section('script')
   
@endsection
