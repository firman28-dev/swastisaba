@extends('partials.index')
@section('heading')
    Jadwal Verifikasi
@endsection
@section('page')
    Data Jadwal Verifikasi
@endsection

@section('content')
    <div class="card shadow-sm rounded-4">
        <form action="{{ route('schedule.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Input Jadwal Verifikasi</h3>
            </div>

            <div class="card-body">
                <div class="row">

                    <input hidden id="group" name="group" value="{{$idGroup->id}}">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group w-100">
                            <label for="role" class="form-label">Role Akses</label>
                            <input name="role" class="form-control form-control-solid" readonly value="{{$idGroup->name}}" />
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
                            <label for="time" class="form-label">Jadwal</label>
                            <input name="time" class="form-control form-control-solid @error('time') is-invalid @enderror" placeholder="Pilih Waktu" id="time" autocomplete="off" />
                        </div>
                        @error('time')
                            <div class="is-invalid">
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            </div>
                        @enderror
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
                    <input type="hidden" id="started_at" name="started_at">
                    <input type="hidden" id="ended_at" name="ended_at">
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
        $("#time").daterangepicker({
            timePicker: true,
            locale: {
                format: "DD/MM/Y hh:mm A"
            }
        },function(start, end, label) {
            const timesStart = start.format('Y-MM-DD H:mm:ss');
            const timesEnd = end.format('Y-MM-DD H:mm:ss');
            // const timesEnd = end;
            document.getElementById("started_at").value = timesStart;
            document.getElementById("ended_at").value = timesEnd;
        });
    </script>
@endsection
