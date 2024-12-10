@extends('partials.index')
@section('heading')
    Dashboard
@endsection
@section('page')
    Dashboard
@endsection


@section('content')
<div class="row">
    {{-- <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <img src="{{asset('assets/img/icon/user.svg')}}" alt="" class="mb-4" />
                <h3 class="text-custom-primary">
                    DATA TATANAN
                </h3>
                <h1 class="text-custom-secondary">
                    {{$category}}
                </h1>
            </div>
        </div>
    </div> --}}
    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="flex-column">
                        <h3 class="text-custom-primary">
                            DATA TATANAN
                        </h3>
                        <h1 class="text-custom-secondary">
                            {{$category}}
                        </h1>
                    </div>
                    <img src="{{asset('assets/img/icon/category.svg')}}" alt="" class="mb-4" />
                </div>
                
            </div>
        </div>
    </div>
   
    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="flex-column">
                        <h3 class="text-custom-primary">
                            DATA PERTANYAAN
                        </h3>
                        <h1 class="text-custom-secondary">
                            {{$questions}}
                        </h1>
                    </div>
                    <img src="{{asset('assets/img/icon/questions.svg')}}" alt="" class="mb-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="flex-column">
                        <h3 class="text-custom-primary">
                            DATA USER
                        </h3>
                        <h1 class="text-custom-secondary">
                            {{$user}}
                        </h1>
                    </div>
                    <img src="{{asset('assets/img/icon/user-2.svg')}}" alt="" class="mb-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="flex-column">
                        <h3 class="text-custom-primary">
                            DATA KABUPATEN/KOTA
                        </h3>
                        <h1 class="text-custom-secondary">
                            @php
                                $zonav2 = $zona->count();
                            @endphp
                            {{$zonav2}}
                        </h1>
                    </div>
                    <img src="{{asset('assets/img/icon/district.svg')}}" alt="" class="mb-4" />
                </div>
                {{-- <img src="{{asset('assets/img/icon-payment.svg')}}" alt="" class="mb-4" /> --}}
            </div>
        </div>
    </div>

    
    

</div>

    @php
        $userprofile = Auth::user();
        // dd($userprofile->id_group);
    @endphp
    @if ($userprofile->id_group === 1 || $userprofile->id_group === 2 || $userprofile->id_group === 5)

    {{-- <div class="card rounded rounded-4 mb-5">
        <div class="card-body">
            <div class="overflow-x-auto w-100">
                <canvas id="kt_chartjs_1"></canvas>
            </div>
        </div>
    </div> --}}


    <div class="card card-bordered mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3>
                    Total Nilai dan Jawaban Kabupaten/Kota
                </h3>
            </div>
            <div class="card-toolbar">
                <form action="{{route('home.showDistrict')}}" method="POST">
                    @csrf
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <select 
                                    id="id_district" 
                                    name="id_district" 
                                    aria-label="Default select example"
                                    class="form-select form-select-solid rounded rounded-4" 
                                    required
                                    autofocus
                                    oninvalid="this.setCustomValidity('Kabupaten/Kota tidak boleh kosong.')"
                                    oninput="this.setCustomValidity('')"
                                >
                                    <option value="" disabled selected>Pilih Kab/Kota</option>
                                    @foreach($searchDistrict as $data)
                                        <option value="{{ $data->id }}" {{ old('id_district') == $data->id ? 'selected' : '' }}>
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_district')
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
            <div id="kt_apexcharts_1" style="overflow-x: auto">
                <div id="chart" style="height: 100%;"> 
                </div>
            </div>
        </div>
    </div>

    @elseif($userprofile->id_group === 6)
    
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

    @else
    <hr>

    @endif
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var ctxAnswer = document.getElementById('kt_chartjs_1');
            var ctxScore = document.getElementById('kt_chartjs_2');


            //color
            var primaryColor = "rgba(255, 99, 132, 0.2)";
            var dangerColor = "rgba(75, 192, 192, 0.2)";
            var successColor = "rgba(54, 162, 235, 0.2)";
            
            //font
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

            const labels = @json($districtNames); // District names
            const dataAnswerDistrict = @json($totalAnswers); // Total answers
            const dataScoreDistrict = @json($totalScore); // Total answers

            // console.log(labels);

            const dataAnswer = {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Jawaban',
                        data: dataAnswerDistrict,
                        backgroundColor: primaryColor,
                        borderColor: "rgb(255, 99, 132)",
                        borderWidth: 1,
                        maxBarThickness: 40
                    },
                ]
            };

            const configAnswer = {
                fontFamily: 'inherit',
                type: 'bar',
                data: dataAnswer,
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                    },
                    indexAxis: 'y',
                    x: {
                        beginAtZero: true,
                        maxBarThickness: 40,
                        ticks: {
                            padding: 20
                        },
                        stacked: false
                    },
                },
                // defaults:{
                //     global: {
                //         defaultFont: 'inherit'
                //     }
                // }
            };

            const dataScore = {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Nilai',
                        data: dataScoreDistrict,
                        backgroundColor: primaryColor,
                        borderColor: "rgb(255, 99, 132)",
                        borderWidth: 1,
                        maxBarThickness: 40
                    },
                ]
            };

            const configScore = {
                type: 'bar',
                data: dataScore,
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                    },
                    indexAxis: 'y',
                    x: {
                        beginAtZero: true,
                        maxBarThickness: 40,
                        ticks: {
                            padding: 20
                        },
                        stacked: false
                    },
                },
                defaults:{
                    global: {
                        defaultFont: fontFamily
                    }
                }
            };

            // var myChartAnswer = new Chart(ctxAnswer, configAnswer);

            // var myChartScore = new Chart(ctxScore, configScore);


            

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--kt-primary');
            var secondaryColor = KTUtil.getCssVariableValue('--kt-success');


            


            const idGroup = @json($idGroup);
            // console.log(idGroup);

            if(idGroup === 2 || idGroup === 1 || idGroup === 5){
                var element = document.getElementById('kt_apexcharts_1');

                var options = {
                    series: [ {
                        name: 'Total Jawaban',
                        data: dataAnswerDistrict
                    },{
                        name: 'Total Nilai',
                        data: dataScoreDistrict
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
                        categories: labels,
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
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }

            if(idGroup === 6){
                var element = document.getElementById('kt_apexcharts_2');
                var elementScore = document.getElementById('kt_apexcharts_3');

                
                const chartData = @json($chartData);
                const labelsCategory = chartData.map(item => item.kategori);
                const dataKabKota = chartData.map(item => item.total_jawaban);
                const dataQuestion = chartData.map(item => item.total_pertanyaan);


                // const totalAllScore = dataQuestion*100;
                const dataallScore = chartData.map(item => item.total_pertanyaan *100);
                const totalScoreKabkota = chartData.map(item => item.total_score);


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

                var chart2 = new ApexCharts(document.querySelector("#chartKabkota"), optionsKabKota);
                chart2.render();

                var chart3 = new ApexCharts(document.querySelector("#chartKabkota2"), optionsScore);
                chart3.render();
            }
            

            // const chartData = [];

            // @foreach ($categoryV2 as $category)
            //     chartData.push({
            //         id: 'chart_{{ $category->id }}',
            //         label: '{{ $category->name }}', // Replace with actual category name
            //         data: [10, 20, 30], // Replace with actual data values
            //         labels: labels // Replace with actual data labels
            //     });
            // @endforeach

            // chartData.forEach((chartConfig) => {
            //     const ctx = document.getElementById(chartConfig.id).getContext('2d');
            //     new Chart(ctx, {
                    
            //         type: 'bar', // or 'line', 'pie', etc.
            //         data: {
            //             labels: chartConfig.labels,
            //             datasets: [{
            //                 label: chartConfig.label,
            //                 data: chartConfig.data,
            //                 backgroundColor: 'rgba(75, 192, 192, 0.2)',
            //                 borderColor: 'rgba(75, 192, 192, 1)',
            //                 borderWidth: 1
            //             }]
            //         },
            //         options: {
            //             indexAxis: 'y',
            //             scales: {
            //                 y: {
            //                     beginAtZero: true
            //                 }
            //             }
            //         }
            //     });
            // });

            
                    
            
            

        });

        $('#id_district').select2({
            placeholder: 'Pilih Kab/Kota',
            allowClear: true
        });
        
    </script>
    
        
@endsection
