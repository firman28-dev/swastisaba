@extends('partials.index')
@section('heading')
Gambaran Umum KabKota
@endsection
@section('page')
    Data Gambaran Umum KabKota
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('gambaran-kabkota.update', $gambaran_kabkota->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Gambaran Umum KabKota</h3>
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
                    <div id="dynamic-input-fields">
                        <div class="row">
                            <div class="col-md-5 mb-4">
                                <div class="form-group w-100">
                                    <label for="name" class="form-label">Nama Gambaran Umum</label>
                                    <textarea id="name" name="name" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Nama Gambaran Umum">{{$gambaran_kabkota->name}}</textarea>
                                    @error('name')
                                        <div class="is-invalid">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 mb-4">
                                <div class="form-group w-100">
                                    <label for="ket" class="form-label">Keterangan</label>
                                    <textarea id="ket" name="ket" class="form-control form-control-solid rounded rounded-4" rows="2" placeholder="Keteragan Gambaran Umum">{{$gambaran_kabkota->ket}}</textarea>
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
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('gambaran-kabkota.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
   
@endsection
