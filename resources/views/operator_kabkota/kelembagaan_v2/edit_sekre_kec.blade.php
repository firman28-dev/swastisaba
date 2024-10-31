@extends('partials.index')
@section('heading')
    Forum Kecamatan
@endsection
@section('page')
    Data Forum Kecamatan

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('kelembagaan-v2.updateSekreKec' , $activity->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Sekretariat Forum Kecamatan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Forum Kecamatan</label>
                            <input type="text"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Forum Kecamatann"
                                name="f_district"
                                required
                                oninvalid="this.setCustomValidity('Forum Kecamatann tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$activity->f_district}}"
                            >
                            @error('f_district')
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
                            <label for="path" class="form-label">Bukti Dokumen <span class="text-danger">*pdf | Max 2MB</span> </label>
                            <input type="file" class="form-control form-control-solid" name="path" id="path">
                            @error('path')
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
                            <label for="address" class="form-label">Alamat Forum Kecamatan</label>
                            <textarea name="address" id="address" cols="3" rows="5" placeholder="Masukkan Alamat Forum"
                                required
                                oninvalid="this.setCustomValidity('Alamat Forum tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                class="form-control form-control-solid rounded-4"
                            >{{$activity->f_district}}</textarea>
                            @error('address')
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
                <a href="{{route('kelembagaan-v2.show', $activity->id_c_kelembagaan)}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#time").flatpickr();
    </script>
@endsection