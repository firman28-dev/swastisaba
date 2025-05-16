@extends('partials.index')
@section('heading')
    Rekap Penilaian
@endsection
@section('page')
    Penilaian
@endsection


@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-header justify-content-between">
        <div class="card-title">
            <h3>Rekap Penilaian </h3>
        </div>
    </div>
    <div class="card-body">
        <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
            <thead>
                <tr class="fw-semibold fs-6 text-muted ">
                    {{-- <th class="w-30px text-center border-1 border align-middle p-3" rowspan="2">No.</th> --}}
                    <th class="w-100px border-1 border align-middle p-3">Nama Kab/Kota </th>
                    <th class="w-100px text-center border-1 border align-middle p-3">Total Jawaban </th>
                    <th class="w-100px text-center border-1 border align-middle p-3">Total Nilai Kab/Kota</th>
                    <th class="w-100px text-center border-1 border align-middle p-3">Status Kab/Kota</th>
                    <th class="w-100px text-center border-1 border align-middle p-3">Total Nilai Provinsi</th>
                    <th class="w-100px text-center border-1 border align-middle p-3">Status Provinsi</th>


                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border-1 border">
                        {{$zona->district_name ?? 0}}
                    </td >
                    <td class="text-center border-1 border">
                        {{$zona->total_jawaban ?? 0}}
                    </td>
                    <td class="text-center border-1 border">
                        {{$zona->total_nilai_kabkota ?? 0}}
                    </td>
                    <td class="text-center border-1 border">
                        @php
                            $score = $zona->total_nilai_kabkota ?? 0;
                            if ($score >= 9656 && $score < 11016) {
                                $status = 'Padapa';
                            } elseif ($score >= 11016 && $score < 12376) {
                                $status = 'Wiwirda';
                            } elseif ($score >= 12376) {
                                $status = 'Wistara';
                            } else {
                                $status = '-';
                            }
                        @endphp
                        {{ $status }}
                    </td>
                    <td class="text-center border-1 border">{{ $zona->total_nilai_provinsi ?? 0 }}</td>
                    <td class="text-center border-1 border">
                        @php
                            $scoreprov = $zona->total_nilai_provinsi ?? 0;
                            if ($scoreprov >= 9656 && $scoreprov < 11016) {
                                $statusprov = 'Padapa';
                            } elseif ($scoreprov >= 11016 && $scoreprov < 12376) {
                                $statusprov = 'Wiwirda';
                            } elseif ($scoreprov >= 12376) {
                                $statusprov = 'Wistara';
                            } else {
                                $statusprov = '-';
                            }
                        @endphp
                        {{ $statusprov }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
        
@endsection
