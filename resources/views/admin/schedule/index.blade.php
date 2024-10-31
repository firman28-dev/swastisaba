@extends('partials.index')
@section('heading')
    Jadwal Verifikasi
@endsection
@section('page')
    Data Jadwal Verifikasi
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>
                    Daftar Jadwal Verifikasi
                </h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableSKPD" class="table table-striped table-row-bordered border" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px text-center border-1 border">No.</th>
                            <th class="w-60px border-1 border"></th>
                            <th class="border-1 border">Nama Role Akses</th>
                            <th class="border-1 border">Waktu Awal</th>
                            <th class="border-1 border">Waktu Akhir</th>
                            <th class="border-1 border">Keterangan</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group as $data)
                            <tr>
                                @php
                                    $schedule_v2 = $schedule->where('id_group',$data->id)->first();
                                @endphp
                                <td class="border-1 border text-center">{{ $loop->iteration }}</td>
                                <td class="border-1 border text-center">
                                    @if ($schedule_v2)
                                        <a href="{{ route('schedule.edit', $schedule_v2->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a> 
                                    @else
                                        <a href="{{ route('schedule.create', $data->id) }}" class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3">
                                            <div class="d-flex justify-content-center">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                        </a> 
                                    @endif
                                                        
                                </td>
                                <td class="text-capitalize border-1 border">{{ $data->name }}</td>
                                
                                @if ($schedule_v2)
                                    <td class="border border-1">{{$schedule_v2->started_at->format('d-m-Y | H:i')}}</td>
                                    <td class="border border-1">{{$schedule_v2->ended_at->format('d-m-Y | H:i')}}</td>
                                    <td class="border border-1">{{$schedule_v2->notes}}</td>

                                @else
                                    <td class="border border-1">-</td>
                                    <td class="border border-1">-</td>
                                    <td class="border border-1">-</td>

                                @endif
                                

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        
    </div>
@endsection

@section('script')
    <script>
        $("#tableSKPD").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom":
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });

        $("#time_{{ $data->id }}").daterangepicker({
            timePicker: true,
            startDate: moment().startOf("hour"),
            endDate: moment().startOf("hour").add(32, "hour"),
            locale: {
                format: "M/DD hh:mm A"
            }
        });
    </script>
@endsection
