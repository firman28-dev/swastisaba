@extends('partials.index')
@section('heading')
    Dashboard {{$districtv2->name}}
@endsection
@section('page')
    <a href="{{ route('home.index') }}" class="text-muted text-hover-primary">
        {{-- Data Kategori --}}
        Dashboard
    </a>
@endsection
@section('sub-page')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <span class="text-gray">
            {{$districtv2->name}}
        </span>
    </li>
@endsection


@section('content')

    <div class="card card-bordered mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3>
                    Total Jawaban Tatanan
                </h3>
            </div>
            <div class="card-toolbar">
                <form action="{{route('home.showCategory',$districtv2->id)}}" method="POST">
                    @csrf
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <select 
                                    id="id_category" 
                                    name="id_category" 
                                    aria-label="Default select example"
                                    class="form-select form-select-solid rounded rounded-4" 
                                    required
                                    autofocus
                                    oninvalid="this.setCustomValidity('Tatanan tidak boleh kosong.')"
                                    oninput="this.setCustomValidity('')"
                                >
                                    <option value="" disabled selected>Pilih Tatanan</option>
                                    @foreach($category as $data)
                                        <option value="{{ $data->id }}" {{ old('id_category') == $data->id ? 'selected' : '' }}>
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_category')
                                    <div class="is-invalid">
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn-sm btn btn-secondary btn-icon" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        
                    </div>
                    
                </form>
            </div>
        </div>
        <div class="card-body">
            <div id="kt_apexcharts_2" style="overflow-x: auto">
                <div id="chartKabkota" style="height: 100%;"> 
                </div>
            </div>
        </div>
    </div>

    <div class="card card-bordered mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3>
                    Total Score Tatanan
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div id="kt_apexcharts_3" style="overflow-x: auto">
                <div id="chartKabkota2" style="height: 100%;"> 
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--kt-primary');
            var secondaryColor = KTUtil.getCssVariableValue('--kt-success');
            var thirdColor = KTUtil.getCssVariableValue('--kt-danger');
        

            var element = document.getElementById('kt_apexcharts_2');
            var elementScore = document.getElementById('kt_apexcharts_3');

                
            const chartData = @json($chartData);
            const labelsCategory = chartData.map(item => item.kategori);
            const dataKabKota = chartData.map(item => item.total_jawaban);
            const dataQuestion = chartData.map(item => item.total_pertanyaan);


            // const totalAllScore = dataQuestion*100;
            const dataallScore = chartData.map(item => item.total_pertanyaan *100);
            const totalScoreKabkota = chartData.map(item => item.total_score);
            const totalScoreFromProv = chartData.map(item => item.total_score_prov);

            // console.log(dataallScore);
            

            // console.log(chartData);

            var optionsKabKota = {
                series: [ {
                    name: 'Total Jawaban',
                    data: dataKabKota
                },{
                    name: 'Total Pertanyaan',
                    data: dataQuestion
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
                colors: [baseColor, secondaryColor],
                grid: {
                    borderColor: borderColor,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                }
            };

            var optionsScore = {
                series: [ {
                    name: 'Score Saat ini',
                    data: totalScoreKabkota
                },{
                    name: 'Total Score Max',
                    data: dataallScore
                },
                {
                    name: 'Total Score Prov',
                    data: totalScoreFromProv
                },
            ],
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
                colors: [baseColor, secondaryColor, thirdColor],
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

            var chart3 = new ApexCharts(document.querySelector("#chartKabkota2"), optionsScore);
            chart3.render();
            
            

        });

        $('#id_category').select2({
            placeholder: 'Pilih Tatanan',
            allowClear: true
        });

    </script>
    
        
@endsection
