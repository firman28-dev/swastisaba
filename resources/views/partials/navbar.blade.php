<div id="kt_app_header" class="app-header">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">

        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../../demo1/dist/index.html" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/img/swastisaba.png') }}" class="w-50px" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <div class="app-header-menu app-header-mobile-drawer align-items-center" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                {{-- @if(Auth::user()->id_group == 6) --}}
                @php
                    $session_date = Session::get('selected_year');
                    if($session_date){
                        $date = \App\Models\Trans_Survey::where('id', $session_date)->first();
                    }
                    else {
                        $date = '';
                    }
                @endphp
                
                <a href="{{route('set-date.index')}}" class="btn btn-sm btn-primary">
                    @if($date)
                        Tahun : {{substr($date->trans_date, 0, 4)}}
                    @else
                        Tahun : -
                    @endif
                </a>
                {{-- <button class="btn btn-sm btn-primary">
                   
                </button> --}}
                {{-- <h1>
                    
                </h1> --}}
                
                    
                {{-- @endif --}}
            </div>
            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        @if (auth()->user()->photo)
                            <img src="{{ asset('uploads/photo/' . auth()->user()->photo) }}" alt="user" />
                        @else
                            <img src="{{ asset('assets/media/blank.png') }}" alt="default user" />
                        @endif
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    @if (auth()->user()->photo)
                                        <img src="{{ asset('uploads/photo/' . auth()->user()->photo) }}" alt="user" />
                                    @else
                                        <img src="{{ asset('assets/media/blank.png') }}" alt="default user" />
                                    @endif
                                    {{-- <img alt="Logo" src="{{ asset('assets/media/avatar-1.jpg') }}" /> --}}
                                </div>
                                @auth
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <span id="name" class="text-capitalize">{{ auth()->user()->username ?? 'User' }}</span>
                                    </div>
                                    <span id="email" class="fw-semibold text-muted text-hover-primary fs-7"></span>
                                </div>
                                @endauth
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="{{route('user.profile')}}" class="menu-link px-5">Profile</a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="{{route('logout.perform')}}" class="menu-link px-5">Sign Out</a>
                        </div>
                    </div>
                </div>

                <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
                                <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>