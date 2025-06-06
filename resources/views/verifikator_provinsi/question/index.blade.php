@extends('partials.index')
@section('heading')
    {{$zona->name}}
@endsection
@section('page')
    Data Kabupaten/Kota
@endsection


@section('content')
    <div class="card card-bordered mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3>
                    Total Jawaban Tatanan
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div id="kt_apexcharts_2" style="overflow-x: auto">
                <div id="chartKabkota" style="height: 100%;"> 
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Tatanan</h3>
            </div>
        </div>
        <div class="card-body">
            <button class="btn btn-success btn-outline btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cetak">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-print"></i> Cetak
                </div>
            </button>
            <div class="modal fade modal-dialog-scrollable" tabindex="-1" id="cetak" data-bs-backdrop="static" data-bs-keyboard="false">
                                    
                <div class="modal-dialog modal-dialog-scrollable">
                    <form action="{{ route('v-prov.printAllCategory')}}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">
                                    Input Berita Acara
                                </h3>
                            </div>
                            <div class="modal-body">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Tahun</label>
                                            <input type="text" value="{{ $tahun->trans_date }}"  readonly class="form-control form-control-solid rounded rounded-4">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Nama Kab/Kota</label>
                                            <input type="text" value="{{ $zona->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Nama Pembahas</label>
                                            <input type="text" required class="form-control form-control-solid rounded rounded-4" id="pembahas" name="pembahas">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Jabatan Pembahas</label>
                                            <input type="text"  required class="form-control form-control-solid rounded rounded-4" id="jabatan" name="jabatan">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Operator</label>
                                            <input type="text" required class="form-control form-control-solid rounded rounded-4" id="operator" name="operator">
                                        </div>
                                    </div> --}}
                                </div>
                                <input type="hidden" name="tahun" value="{{ $tahun->id }}">
                                <input type="hidden" name="kota" value="{{ $zona->id}}">
                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-4">Cetak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1">No.</th>
                            <th class="border border-1">Nama Tatanan</th>
                            <th class="border border-1 text-center">Status BA Tatanan</th>

                            <th class="border border-1 w-300px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $data->name }}</td>
                                <td class="border border-1 text-center">
                                    @php
                                        $ba = \App\Models\BA_Pertatanan::where('id_zona', $zona->id)
                                        ->where('id_survey',$tahun->id)
                                        ->where('id_category', $data->id)
                                        ->first();
                                    @endphp
                                    @if ($ba)
                                        <span class="badge badge-success"><i class="fa-solid fa-check text-white "></i></span>
                                    @else
                                        <span class="badge badge-danger"><i class="fa-solid fa-xmark text-white"></i></span>
                                    @endif
                                </td>
                                <td class="border border-1">
                                    <a href="{{route('v-prov.showCategory',['id_zona' => $zona->id, 'id' => $data->id]) }}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat Pertanyaan
                                    </a>
                                </td>
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
            responsive: true,
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

        document.addEventListener('DOMContentLoaded', () => {
            var element = document.getElementById('kt_apexcharts_2');
            const chartData = @json($chartData);
            const labelsCategory = chartData.map(item => item.kategori);
            const dataKabKota = chartData.map(item => item.total_jawaban);
            const dataProv = chartData.map(item => item.total_jawabanprov);
            const dataQuestion = chartData.map(item => item.total_pertanyaan);
            
            //color
            var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--kt-primary');
            var secondaryColor = KTUtil.getCssVariableValue('--kt-success');
            var thirdColor = KTUtil.getCssVariableValue('--kt-danger');


            console.log(chartData);
            

            var optionsKabKota = {
                series: [ {
                    name: 'Total Jawaban Kab/Kota',
                    data: dataKabKota
                },{
                    name: 'Total Pertanyaan',
                    data: dataQuestion
                },{
                    name: 'Total Jawaban Prov',
                    data: dataProv
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    // height: 600,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: ['50%'],
                        endingShape: 'rounded'
                    },
                },
                legend: {
                    show: true,
                    position: 'top'
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: labelsCategory,
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return val 
                        }
                    }
                },
                colors: [baseColor, secondaryColor,thirdColor],
                grid: {
                    borderColor: borderColor,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                }
            };

            var chart2 = new ApexCharts(document.querySelector("#chartKabkota"), optionsKabKota);
            chart2.render();
        });

        

    </script>
@endsection
