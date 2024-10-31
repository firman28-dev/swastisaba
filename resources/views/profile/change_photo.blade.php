@extends('partials.index')
@section('heading')
    Profile
@endsection
@section('page')
    Data Profile
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('user.updatePhoto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Edit Photo</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="photo">Unggah Foto </label>
                            <p class="required">(JPEG, PNG, JPG, dan GIF) Ukuran maksimal 2 MB</p>
                            <input type="file" name="photo" class="form-control form-control-solid" accept="image/*">
                            @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('user.profile')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection
@section('script')
   
@endsection
