<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/custom/custom.css')}}" rel="stylesheet" type="text/css" />
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    
    <title>Error-Page</title>
</head>
<body class="bg-error justify-content-center">

    <div class="d-flex container justify-content-center text-center">
        <div class="card w-50 rounded-4">
            <div class="card-body d-flex flex-column flex-center">
                <h1>
                    Oops!
                </h1>
                <h4>
                    Kamu tidak bisa mengakses halaman ini.
                </h4>
                <img src="{{asset('assets/media/404-error.png')}}" alt="" class="w-75">
                <a href="{{route('user.profile')}}" class="btn btn-outline btn-outline-primary">
                    Kembali ke beranda
                </a>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
</body>
</html>