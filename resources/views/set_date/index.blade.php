@extends('partials.index')
@section('heading')
    Seting Tahun Data
@endsection
@section('page')
Seting Tahun Data
@endsection


@section('content')
    <div class="card">
        <form action="{{route('set-date.store')}}" method="POST">
            @csrf
            <div class="card-header justify-content-between">
                <div class="card-title">
                    <h3>
                        Silahkan Setting  Tahun Data
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group w-100">
                            <label for="name" class="form-label">Tahun Periode</label>
                            <select 
                                id="trans_date" 
                                name="trans_date" 
                                aria-label="Default select example"
                                class="form-select form-select-solid rounded rounded-4" 
                                required
                                autocomplete="off"
                                autofocus
                            >
                            <option value="" disabled selected></option>
                            @foreach($t_date as $data)
                                <option value="{{ $data->id }}" {{session('selected_year') == $data->id ? 'selected' : ''}}>
                                    {{ substr($data->trans_date, 0, 4) }}
                                </option>
                            @endforeach
                            </select>
                            
                            @error('t_date')
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
                <button type="submit" class="btn btn-primary btn-sm hover-scale">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('#trans_date').select2({
            placeholder: 'Pilih Tahun',
            allowClear: true
        });
    </script>
@endsection
