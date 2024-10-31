<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="" />
        <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/custom/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@400;500;600;700;800;900&family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>
		<link rel="icon" type="image/png" href="{{ asset('assets/img/swastisaba.png') }}" sizes="32x32">
        
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <meta
            name="author"
            content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
        />
        <meta name="generator" content="Hugo 0.87.0" />
        <title>Sign Swastisaba</title>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
            crossorigin="anonymous"
        />
    </head>

    <body id="kt_body" class="app-blank">
        <div class="d-flex flex-column flex-root h-100" id="kt_app_root">
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">    
                <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                        <div class="w-lg-500px p-10">
                            @yield('content')
                        </div>
                    </div>
                        
                </div>

                <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2 bg-login" >
                    <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">          
                        <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7"> 
                            SWASTISABA
                        </h1>  
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_50 Kota.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Agam.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Dharmasraya.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Kep_Mentawai.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Padang Pariaman.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Pasaman.png')}}" alt="">                 
                            </div>
                            
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Solok.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Tanah Datar.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Pasbar.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Pessel.png')}}" alt="">                 
                            </div>
                             <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Sijunjung.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-2">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kab_Solok_Selatan.png')}}" alt="">                 
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Bukittinggi.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-3">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Padang Panjang.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-3">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Padang.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-3">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Pariaman.png')}}" alt="">                 
                            </div>
                            
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Solok.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-4">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Payakumbuh.png')}}" alt="">                 
                            </div>
                            <div class="col-lg-4">
                                <img class="d-none d-lg-block mx-auto w-75px " src="{{asset('assets/media/icon-kabkota/Kota_Sawahlunto.png')}}" alt="">                 
                            </div>
                        </div>
                        {{-- <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{asset('assets/media/10-dark.png')}}" alt="">                  --}}
                        
                    </div>
                </div>
            </div>
            
        </div>
    

        <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
        @yield('script')
    </body>


</html>