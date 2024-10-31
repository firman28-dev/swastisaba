@extends('partials.index')
@section('heading')
    Jadwal Verifikasi
@endsection
@section('page')
    Data Jadwal Verifikasi
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('schedule.update', $schedule->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-header">
                <h3 class="card-title">Input Jadwal Verifikasi</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- <input hidden id="group" name="group" value="{{$schedule->id}}"> --}}
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="role" class="form-label">Role Akses</label>
                            <input name="role" class="form-control form-control-solid" readonly value="{{$schedule->_group->name}}" />
                        </div>
                        @error('role')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="started_at" class="form-label">Waktu Awal</label>
                            <input 
                                name="started_at" 
                                class="form-control form-control-solid"  
                                placeholder="Pilih Waktu Awal" 
                                id="started_at" 
                                required value="{{ $schedule->started_at }}"
                            />
                            @error('started_at')
                                <div class="invalid-feedback">
                                    <span>
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="ended_at" class="form-label">Waktu Berakhir</label>
                            <input 
                                name="ended_at" 
                                class="form-control form-control-solid" 
                                placeholder="Pilih Waktu Berakhir" 
                                id="ended_at" 
                                required 
                                value="{{ $schedule->ended_at }}"
                            />
                            @error('ended_at')
                                <div class="invalid-feedback">
                                    <span>
                                        {{$message}}
                                    </span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="notes" class="form-label">Keterangan</label>
                            <input 
                                type="text" 
                                name="notes" 
                                class="form-control form-control-solid" 
                                id="notes"
                                placeholder="Masukkan Keterangan"
                                required
                                oninvalid="this.setCustomValidity('Keterangan tidak boleh kosong.')"
                                oninput="this.setCustomValidity('')"
                                value="{{$schedule->notes}}"
                            />
                        </div>
                        @error('notes')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
                    </div>
                    {{-- <input type="hidden" id="started_at" name="started_at"> --}}
                    {{-- <input type="hidden" id="ended_at" name="ended_at"> --}}
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                &nbsp;
                <a href="{{route('schedule.index')}}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $("#ended_at").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
        $("#started_at").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",    
        });
    </script>
@endsection


