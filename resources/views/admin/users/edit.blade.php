@extends('partials.index')
@section('heading')
    User
@endsection
@section('page')
    Data User
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Edit Data user</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="id_group" class="form-label">Role Akses</label>
                            <select 
                                id="id_group" 
                                name="id_group" 
                                aria-label="Default select example"
                                class="form-select form-select-solid rounded rounded-4" 
                                required
                                autocomplete="off"
                                autofocus
                            >
                                <option value="" disabled selected>Pilih Role Akses</option>
                                @foreach($group as $data)
                                    <option value="{{ $data->id }}" {{ old('id_group') == $data->id ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_group')
                                <div class="is-invalid">
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4 d-none" id="operatorField">
                        <div class="form-group">
                            <label for="id_zona" class="form-label">Kabupaten/Kota</label>
                            <select 
                                id="id_zona" 
                                name="id_zona" 
                                aria-label="Default select example"
                                class="form-select form-select-solid rounded rounded-4" 
                                autocomplete="off"
                                autofocus
                            >
                                <option value="" disabled selected>Pilih Kab/Kota</option>
                                @foreach($zona as $data)
                                    <option value="{{ $data->id }}" {{ old('id_group') == $data->id ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_zona')
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
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Username"
                                required
                                autofocus
                                autocomplete="off"
                                oninvalid="this.setCustomValidity('Username tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$user->username}}"
                            >
                            @error('username')
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
                            <label for="name" class="form-label">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control form-control-solid rounded rounded-4"
                                placeholder="Masukkan Password"
                                required
                                autocomplete="off"
                                autofocus
                                oninvalid="this.setCustomValidity('Password tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                
                            >
                            @error('password')
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
                <a href="{{route('user.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection
@section('script')
    <script>

        $(document).ready(function() {
            $('#id_group').select2({
                placeholder: 'Pilih Role Akses',
                allowClear: true
            });
            $('#id_zona').select2({
                placeholder: 'Pilih Kab/Kota',
                allowClear: true
            });

            const operatorKabkotaField = document.getElementById('operatorField');

            $('#id_group').on('select2:select', function(e) {
                const selectedValue = e.params.data.id;
                console.log(selectedValue);
                
                if (selectedValue === '6') {
                    operatorKabkotaField.classList.remove('d-none');
                } else {
                    operatorKabkotaField.classList.add('d-none');
                }
            });
        });
        
        // $("#id_zona").select2();
        // $("#id_group").select2();
        // const selectElement = document.getElementById('id_group');
        // const operatorKabkotaField = document.getElementById('operatorField');

        // selectElement.addEventListener('change', function() {
        //     const selectedValue = this.value;
        //     console.log(selectedValue);
            
        //     if (selectedValue === 'Operator Kabupaten/Kota') {
        //         operatorKabkotaField.classList.remove('d-none');
        //     } else {
        //         operatorKabkotaField.classList.add('d-none');
        //     }
        // });
        
        

    </script>
@endsection
