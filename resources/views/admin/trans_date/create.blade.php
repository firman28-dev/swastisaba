@extends('partials.index')
@section('heading')
Periode Tahun
@endsection
@section('page')
    Data Periode Tahun
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('trans-date.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Periode Tahun</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="trans_date" class="form-label">Periode Tahun</label>
                            <input type="text" id="trans_date" name="trans_date"
                                class="form-control form-control-solid"
                                maxlength="4"
                                autofocus
                                autocomplete="off"
                                placeholder="Buat Tahun" required
                                oninvalid="this.setCustomValidity('Tahun tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')" 
                            />
                            @error('trans_date')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                            {{-- <label for="name" class="form-label">Nama Pasien</label>
                            <input type="date" id="name" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"> --}}
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('trans-date.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection
@section('script')
    <script>
        $('#trans_date').maxlength({
            threshold: 4,
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-success"
        });
    </script>
@endsection
