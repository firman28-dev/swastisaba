{{-- <!DOCTYPE html>
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
        <meta
            name="author"
            content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
        />
        <meta name="generator" content="Hugo 0.87.0" />
        <title>Sign Swastisaba</title>
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
                    </div>
                </div>
            </div>
            
        </div>
    

        <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
        @yield('script')
    </body>


</html> --}}

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Aldi Duzha" />
    <meta name="description" content="Swastisaba aplikasi KKS Provinsi Sumbar" />
    <meta name="keywords" content="swastisaba, kks, sumbar, tatanan, odf" />
    <link rel="canonical" href="https://swastisaba.sumbarprov.go.id/" />
    <title>Swastisaba - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
	<link rel="icon" type="image/png" href="{{ asset('assets/img/swastisaba.png') }}" sizes="32x32">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@1/css/bulma.min.css"
      integrity="sha256-efrxyTTvKJ2Q1/BD8p9dZFtTEcil+cMzxZeL/7hdO2g="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-social@1/bin/bulma-social.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css"
      integrity="sha256-5eIC48iZUHmSlSUz9XtjRyK2mzQkHScZY1WdMaoz74E="
      crossorigin="anonymous"
    />
    <style>
        html,
        body {
            font-family: 'Quicksand', serif;
            font-size: 12px;
            font-weight: 300;
            overflow-y: hidden;
            /* overflow-x: hidden; */
            background: url("{{ asset('assets/img/testing.jpg') }}") center/cover no-repeat;
        }
        .box {
            margin-top: 5rem;
            background-color: rgba(0, 0, 0, 0.4);
        }

        input {
            font-weight: 300;
        }

        p {
            font-size: 12px;
            font-weight: 700;
        }

        p.subtitle {
            padding-top: 1rem;
        }

        a {
            color: #fff;
        }

        a:hover {
            color: #bababa;
        }

        .languages {
            margin-top: 10px;
        }
        .pointer-icon {
            /* display: inline-block; Pastikan span tampil sebagai blok */
            cursor: pointer !important;
            user-select: none; /* Nonaktifkan seleksi teks saat diklik */
        }
    </style>
  </head>
  <body>
    <section class="hero is-fullheight">
        <div class="hero-body">
            
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    @include('layouts.partials.messages')
                    <div class="is-flex-direction-row is-align-items-center	">
                        <img src="{{asset('assets/img/SWASTISABA2.png')}}" alt="Logo" style="width: 25%"  class="mb-3">
                        <img src="{{asset('assets/img/SUMBAR.png')}}" alt="Logo" style="width: 25%"  class="mb-3">
                    </div>
                    <div class="box p-6 mb-0 mt-0">
                        <p class="subtitle is-4 pb-5 has-text-weight-bold has-text-white">Silahkan Login</p>
                        <form method="post" action="{{ route('login.perform') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="field">
                                <div class="control has-icons-left has-icons-right">
                                    <input 
                                        class="input is-medium" 
                                        type="text" 
                                        placeholder="Username atau Email" 
                                        name="username"
                                        value="{{ old('username') }}"
                                        autofocus
                                        required
                                        autocomplete="off"
                                        oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                    />
                                    <span class="icon is-medium is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control has-icons-left has-icons-right">
                                    <input 
                                        class="input is-medium" 
                                        type="password" 
                                        placeholder="Password" 
                                        id="password"
                                        name="password"
                                        value="{{ old('password') }}"
                                        required
                                        autocomplete="new-password"
                                        oninvalid="this.setCustomValidity('Kolom tidak boleh kosong.')"
                                        oninput="this.setCustomValidity('')"
                                    />
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <span class="icon is-small is-right" style="pointer-events: all; cursor: pointer"  onclick="togglePassword()">
                                        <i id="toggle-icon" class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>
                        
                            <div class="column is-flex is-half is-offset-one-quarter">
                                <button class="button is-block is-info is-medium is-fullwidth has-text-weight-normal has-text-dark">
                                Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <p class="mt-5 mb-3 text-muted has-text-white has-text-weight-bold">Copyright &copy; {{ date('Y') }}</p>

                </div>
            </div>

        </div>
        <div class="is-flex-direction-column is-justify-content-center">

        </div>
    </section>
   
   

    <script>
        function togglePassword() {
            console.log('hh');
            
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            
            // Check the current type of password input
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Show the password
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye'); // Update icon
            } else {
                passwordField.type = 'password'; // Hide the password
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash'); // Update icon
            }
        }
    </script>
  </body>
</html>
