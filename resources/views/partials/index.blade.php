<!DOCTYPE html>
<html lang="en">
	<head>
        {{-- <base href=""/> --}}
		<title>Swastisaba</title>
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/custom/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link rel="icon" type="image/png" href="{{ asset('assets/img/swastisaba.png') }}" sizes="32x32">
		<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@400;500;600;700;800;900&family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
	</head>
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
				@if ($errors->any())
					@foreach ($errors->all() as $error)
						toastr.error('{{ $error }}');
					@endforeach
				@endif

				
                @if (session('success'))
                    toastr.success('{{ session('success') }}');
                @endif
    
                @if (session('error'))
                    toastr.error('{{ session('error') }}');
                @endif
            });
        </script>
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<div class="app-page flex-column flex-column-fluid h-100" id="kt_app_page">
                {{-- @include('layout.navbar') --}}
                @include('partials.navbar')
                
                
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <div>
                        @include('partials.sidebar')
                    </div>
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">@yield('heading')</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{route('home.index')}}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">
												<span class="text-gray">
                                                    @yield('page')
                                                </span>
                                            </li>
                                            @yield('sub-page')
                                            
										</ul>
									</div>
								</div>
							</div>

							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
						@include('partials.footer')
					</div>
				</div>
			</div>
		</div>

		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
		</div>

		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
        @yield('script')

		<script>
			let lastActivity = Date.now();
			const inactivityLimit = 10 * 60 * 1000; // 10 menit

			function checkInactivity() {
				const currentTime = Date.now();
				const inactiveTime = currentTime - lastActivity;

				if (inactiveTime > inactivityLimit) {
					logout();
				}
			}

			function logout() {
				console.log("User  has been logged out due to inactivity.");

				$.ajax({
					url: '/logout',
					type: 'GET',
					success: function(response) {
						window.location.href = '/login'; 
					},
					error: function(xhr, status, error) {
						console.error("Logout failed:", error);
					}
				});
			}
			document.addEventListener('mousemove', resetTimer);
			document.addEventListener('keypress', resetTimer);

			function resetTimer() {
				lastActivity = Date.now();
			}

			// Memeriksa aktivitas setiap menit
			setInterval(checkInactivity, 60 * 1000);
			// console.log(lastActivity);
			
		</script>
	</body>
</html>
