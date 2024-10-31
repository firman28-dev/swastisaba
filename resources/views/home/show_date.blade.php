<!DOCTYPE html>
<html lang="en">
	<head>
        {{-- <base href=""/> --}}
		<title>Swastisaba</title>
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/custom/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link rel="icon" type="image/png" href="{{ asset('assets/img/swastisaba.png') }}" sizes="32x32">

		<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@400;500;600;700;800;900&family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        
    </head>
	<body id="kt_app_body" class="app-default bg-show-date" >
		<div class="d-flex flex-row flex-root app-root align-items-center justify-content-center" id="kt_app_root">
			<div class="d-flex flex-column justify-content-center ">
                <h1 class="display-6 text-white text-center">
                    Selamat Datang di Swastisaba
                </h1>
                <div class="d-flex flex-sm-row flex-column justify-content-around mt-4">
                    @foreach ($t_date as $item)
                    {{-- <div data-aos="slide-up" data-aos-duration="500" data-aos-easing="ease-in-out">
                        <form action="{{ route('home.store') }}" method="POST" id="surveyForm">
                            @csrf 
                            <input type="hidden" name="id_survey" value="{{$item->id}}">
                            <div class="card bg-white shadow-lg mb-sm-0 mb-3 bg-gradient rounded rounded-4 cursor-pointer" data-id="{{$item->id}}" onclick="submitForm(this)">
                                <div class="card-body">
                                    <h2>
                                        {{$item->trans_date}}
                                    </h2>
                                </div>
                            </div>
                        </form>
                    </div> --}}

                    <div data-aos="slide-up" data-aos-duration="500" data-aos-easing="ease-in-out">
                        <input type="hidden" id="id_survey_{{$item->id}}" name="id_survey" value="{{$item->id}}">
                        <div class="card bg-white shadow-lg mb-sm-0 mb-3 bg-gradient rounded rounded-4 cursor-pointer hover-elevate-up" onclick="sendSurvey('{{$item->id}}')">
                            <div class="card-body">
                                <h2>
                                    {{$item->trans_date}}
                                </h2>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
		</div>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
        <script>
            // function handleCardClick(cardElement) {
            //     const cardId = cardElement.getAttribute('data-id');
            //     console.log('ID Card:', cardId);
            //     $.ajax({    
            //         url: '/set-year', // Ganti dengan route ke controller yang sesuai
            //         method: 'POST',
            //         data: {
            //             id: cardId,
            //             _token: '{{ csrf_token() }}' // Sertakan CSRF token untuk keamanan
            //         },
            //         success: function(response) {
            //             console.log('Response from server:', response);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error:', error);
            //         }
            //     }); 
            // }

            // function submitForm(cardElement) {
            //     // Ambil form dari elemen card
            //     const form = document.getElementById('surveyForm');
            //     form.submit();
            // }

            function sendSurvey(surveyId) {
                var idSurvey = $('#id_survey_' + surveyId).val();

                $.ajax({
                    url: '/set-year',  // Replace with your Laravel route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // CSRF token for security
                        id_survey: idSurvey
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.href = '/dashboard';
                        // Handle success (display a message or redirect, etc.)
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        // Handle error (show an error message, etc.)
                    }
                });
            }
        </script>
	</body>
</html>
