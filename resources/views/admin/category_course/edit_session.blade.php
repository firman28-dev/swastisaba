@extends('partials.index')
@section('heading')
    Sesi Pelatihan
@endsection
@section('page')
    Data Sesi Pelatihan
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('category-course.updateSession', $session_course->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Edit Data Sesi Pelatihan</h3>
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
                            <input type="text" id="id_survey" class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Tahun" required
                                oninvalid="this.setCustomValidity('Tahun tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')" value="{{$date->trans_date ?? ''}}" readonly>
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
                            <label for="id_category" class="form-label">Kategori Pelatihan</label>
                            <input type="text" class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan kategori" required
                                oninvalid="this.setCustomValidity('Kategory tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')" readonly value="{{$category->name}}">
                            <input hidden name="id_category" value="{{$category->id}}">
                            @error('id_category')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">Nama Sesi</label>
                            <input type="text" name="name" class="form-control form-control-solid rounded rounded-4" placeholder="Nama Sesi" required autocomplete="off" value="{{$session_course->name ?? ''}}">
                            @error('name')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">Deskripsi Sesi</label>
                            <input type="text" name="description" class="form-control form-control-solid rounded rounded-4" placeholder="Deskripsi" required autocomplete="off" value="{{$session_course->description ?? ''}}">
                            @error('description')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select id="is_active" name="is_active" class="form-select form-select-solid rounded rounded-4"
                                required autocomplete="off">
                                <option value="" disabled>Pilih Status</option>
                                <option value="1" {{ old('is_active', $session_course->is_active ?? '') == '1' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="0" {{ old('is_active', $session_course->is_active ?? '') == '0' ? 'selected' : '' }}>
                                    Non Aktif</option>
                                
                            </select>
                            @error('is_active')
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
                <a href="{{ route('category-course.show', $category->id) }}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>

@endsection

@section('script')
    <script>
        $("#is_active").select2();

        
    </script>
@endsection