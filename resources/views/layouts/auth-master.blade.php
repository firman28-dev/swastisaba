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
      {{-- integrity="sha256-efrxyTTvKJ2Q1/BD8p9dZFtTEcil+cMzxZeL/7hdO2g=" --}}
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-social@1/bin/bulma-social.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css"
      {{-- integrity="sha256-5eIC48iZUHmSlSUz9XtjRyK2mzQkHScZY1WdMaoz74E=" --}}
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
                        @yield('content')
                    </div>
                    <p class="mt-5 mb-3 text-muted has-text-white has-text-weight-bold">Copyright &copy; {{ date('Y') }}</p>

                </div>
            </div>

        </div>
        <div class="is-flex-direction-column is-justify-content-center">

        </div>
    </section>
   
   

    @yield('script')
  </body>
</html>
