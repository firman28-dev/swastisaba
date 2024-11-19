<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="#">
            <img alt="Logo" src="{{asset('assets/img/swastisaba.png')}}" class=" app-sidebar-logo-default w-25" />
            
        </a>
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                
                <div class="menu-item">
                    <a class="menu-link  {{ request()->routeIs('home.index', 'home.getDistrict', 'home.showCategory', 'home.showDistrict')  ? 'active' : '' }}" href="{{ route('home.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house fs-3"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-user fs-3"></i>
                            {{-- <i class="fa-solid fa-house fs-3"></i> --}}
                        </span>
                        <span class="menu-title">Profile</span>
                    </a>
                </div>

                {{-- <div class="menu-item">
                    <a class="menu-link {{ Route::is('set-date.index') ? 'active' : '' }}" href="{{route('set-date.index')}}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-bars-progress fs-3"></i>
                        </span>
                        <span class="menu-title">Setting Tahun</span>
                    </a>
                </div> --}}

                @if(Auth::user()->id_group == 1)
                    <div class="menu-item pt-5"><!--begin:Menu content-->
                        <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Kabupaten/Kota</span>
                        </div><!--end:Menu content-->
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-pusat.indexGData') || Route::is('v-pusat.indexGData') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Gambaran Umum</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-pusat.indexGData') && request()->id == $zona->id ||
                                        (request()->routeIs('v-pusat.indexGData') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-pusat.indexGData', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-pusat.indexKelembagaan') || Route::is('v-pusat.showCategory') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Kelembagaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-pusat.indexKelembagaan') && request()->id == $zona->id ||
                                        (request()->routeIs('v-pusat.showCategory') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-pusat.indexKelembagaan', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-pusat.indexPendanaan') || Route::is('v-pusat.indexPendanaan') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Pendanaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-pusat.indexPendanaan') && request()->id == $zona->id ||
                                        (request()->routeIs('v-pusat.indexPendanaan') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-pusat.indexPendanaan', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-pusat.indexQuestion') || Route::is('v-pusat.showCategory') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Tatanan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-pusat.indexQuestion') && request()->id == $zona->id ||
                                        (request()->routeIs('v-pusat.showCategory') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-pusat.indexQuestion', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="menu-item menu-accordion {{ Route::is('v-pusat.indexNarasi') || Route::is('v-pusat.indexNarasi') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Narasi Tatanan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-pusat.indexNarasi') && request()->id == $zona->id ||
                                        (request()->routeIs('v-pusat.indexNarasi') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-pusat.indexNarasi', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item pt-5"><!--begin:Menu content-->
                        <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Provinsi</span>
                        </div><!--end:Menu content-->
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-pusat.showDocProv') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-building fs-3"></i>
                            </span>
                            <span class="menu-title">Dokumen Provinsi</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\Category_Doc_Provinsi::all() as $category)
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('v-pusat.showDocProv') && request()->id == $category->id ? 'active' : '' }}" href="{{ route('v-pusat.showDocProv', ['id' => $category->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $category->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    

                @endif

                @if(Auth::user()->id_group == 2)
                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('trans-date.*') && !Route::is('trans-date.onlyTrashed') ? 'active' : '' }}" href="{{route('trans-date.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-calendar-days fs-3"></i>
                                {{-- <i class="fa-solid fa-house fs-3"></i> --}}
                            </span>
                            <span class="menu-title">Periode Data</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('schedule.*') ? 'active' : '' }}" href="{{route('schedule.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-calendar-days fs-3"></i>
                                {{-- <i class="fa-solid fa-house fs-3"></i> --}}
                            </span>
                            <span class="menu-title">Jadwal Verifikasi</span>
                        </a>
                    </div>

                    <div class="menu-item menu-accordion {{ 
                        (Route::is('zona.*') || 
                        Route::is('user.*') || 
                        // Route::is('level.*') || 
                        Route::is('group.*')) && 
                        !Route::is('zona.onlyTrashed')  &&
                        !Route::is('level.onlyTrashed') &&
                        !Route::is('user.profile')  &&
                        !Route::is('user.onlyTrashed')  &&
                        !Route::is('group.onlyTrashed')
                        ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-list-check fs-3"></i>
                            </span>
                            <span class="menu-title">Manajemen User</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('group.*') && !Route::is('group.onlyTrashed') ? 'active' : '' }}" href="{{route('group.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Role Akses</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('zona.*') && !Route::is('zona.onlyTrashed') ? 'active' : '' }}" href="{{route('zona.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Kabupaten/Kota</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('user.*') && !Route::is('user.onlyTrashed') && !Route::is('user.profile') ? 'active' : '' }}" href="{{route('user.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data User</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ 
                        Route::is('category.onlyTrashed') ||
                        Route::is('questions.onlyTrashed') ||
                        Route::is('q-option.onlyTrashed') ||
                        // Route::is('level.onlyTrashed') ||
                        Route::is('zona.onlyTrashed') ||
                        Route::is('doc-g-data.onlyTrashed') ||
                        Route::is('c-kelembagaan.onlyTrashed') ||
                        Route::is('q-kelembagaan.onlyTrashed') ||
                        Route::is('group.onlyTrashed') ||
                        Route::is('c-doc-prov.onlyTrashed') ||
                        Route::is('user.onlyTrashed') ||
                        Route::is('sub-doc-prov.onlyTrashed') ||
                        Route::is('doc-question.onlyTrashed') ||
                        Route::is('trans-date.onlyTrashed')



                        ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-trash fs-3"></i>
                            </span>
                            <span class="menu-title">Data Sampah</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('category.onlyTrashed') ? 'active' : '' }}" href="{{route('category.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Tatanan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('questions.onlyTrashed') ? 'active' : '' }}" href="{{route('questions.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Pertanyaan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('q-option.onlyTrashed') ? 'active' : '' }}" href="{{route('q-option.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Opsi Pertanyaan</span>
                                </a>
                            </div>
                            {{-- <div class="menu-item">
                                <a class="menu-link {{ Route::is('group.onlyTrashed') ? 'active' : '' }}" href="{{route('group.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Role User</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('zona.onlyTrashed') ? 'active' : '' }}" href="{{route('zona.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Kabupaten/Kota</span>
                                </a>
                            </div> --}}
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('c-kelembagaan.onlyTrashed') ? 'active' : '' }}" href="{{route('c-kelembagaan.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Kategori Kelembagaan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('q-kelembagaan.onlyTrashed') ? 'active' : '' }}" href="{{route('q-kelembagaan.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Pertanyaan Kelembagaan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('doc-g-data.onlyTrashed') ? 'active' : '' }}" href="{{route('doc-g-data.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Dokumen Data Umum</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('c-doc-prov.onlyTrashed') ? 'active' : '' }}" href="{{route('c-doc-prov.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori Dokumen Provinsi</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('sub-doc-prov.onlyTrashed') ? 'active' : '' }}" href="{{route('sub-doc-prov.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Sub Kategori Dokumen Provinsi</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('doc-question.onlyTrashed') ? 'active' : '' }}" href="{{route('doc-question.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Dokumen Pendukung Pertanyaan</span>
                                </a>
                            </div>

                            {{-- <div class="menu-item">
                                <a class="menu-link {{ Route::is('trans-date.onlyTrashed') ? 'active' : '' }}" href="{{route('trans-date.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Periode Tahun</span>
                                </a>
                            </div> --}}

                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('user.onlyTrashed') ? 'active' : '' }}" href="{{route('user.onlyTrashed')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">User</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-item menu-accordion {{ (Route::is('c-doc-prov.*') || Route::is('showSubDoc')  || Route::is('sub-doc-prov.*')) && !Route::is('c-doc-prov.onlyTrashed') && !Route::is('sub-doc-prov.onlyTrashed') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-building fs-3"></i>
                            </span>
                            <span class="menu-title">Dokumen Provinsi</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('c-doc-prov.*')? 'active' : '' }}" href="{{route('c-doc-prov.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori Dokumen Provinsi</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('sub-doc-prov.*') || Route::is('showSubDoc') ? 'active' : '' }}" href="{{route('sub-doc-prov.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Sub Dokumen Provinsi</span>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    
                   
                    <div class="menu-item pt-5"><!--begin:Menu content-->
                        <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Kabupaten Kota</span>
                        </div><!--end:Menu content-->
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('gambaran-kabkota.*') ? 'active' : '' }}" href="{{route('gambaran-kabkota.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Gambaran Umum KabKota</span>
                        </a>
                    </div>

                    <div class="menu-item menu-accordion {{
                        (Route::is('c-kelembagaan-v2.*') || 
                        Route::is('q-kelembagaan-v2.*') || 
                        Route::is('q-opt-kelembagaan.index') || 
                        Route::is('showQKelembagaanNew')) && 
                        !Route::is('c-kelembagaan.onlyTrashed')  &&
                        !Route::is('q-kelembagaan.onlyTrashed')
                        ? 'show' : ''
                    }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-industry fs-3"></i>
                            </span>
                            <span class="menu-title">Kelembagaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('c-kelembagaan-v2.*') ? 'active' : '' }}" href="{{route('c-kelembagaan-v2.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori Kelembagaan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ 
                                    Route::is('q-kelembagaan-v2.*') || 
                                    Route::is('showQKelembagaanNew') || 
                                    Route::is('q-opt-kelembagaan.index') ||
                                    Route::is('q-opt-kelembagaan.create') ||
                                    Route::is('q-opt-kelembagaan.edit') 
                                    ? 'active' : '' 
                                    }}" href="{{route('q-kelembagaan-v2.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Pertanyaan Kelembagaan</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('pendanaan.*') ? 'active' : '' }}" href="{{route('pendanaan.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Pendanaan</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('category.*') && !Route::is('category.onlyTrashed') ? 'active' : '' }}" href="{{route('category.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Tatanan</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ (Route::is('questions.*') || Route::is('showQuestionV1')) && !Route::is('questions.onlyTrashed') ? 'active' : '' }}" href="{{route('questions.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-clipboard fs-3"></i>
                            </span>
                            <span class="menu-title">Pertanyaan</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ (Route::is('q-option.*') || Route::is('showQuestionV2') || Route::is('showQuestionOpt') || Route::is('doc-question.index') || Route::is('doc-question.create')) && !Route::is('q-option.onlyTrashed') ? 'active' : '' }}" href="{{route('q-option.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-pen fs-3"></i>
                            </span>
                            <span class="menu-title">Opsi Pertanyaan dan Data Dukung</span>
                        </a>
                    </div>

                    {{-- <div class="menu-item">
                        <a class="menu-link {{ (Route::is('q-option.*') || Route::is('showQuestionV2') || Route::is('showQuestionOpt')) && !Route::is('q-option.onlyTrashed') ? 'active' : '' }}" href="{{route('q-option.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-file-lines fs-3"></i>
                            </span>
                            <span class="menu-title">Data Pendukung</span>
                        </a>
                    </div> --}}
                    
                    

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('g-data.*') || Route::is('') ? 'active' : '' }}" href="{{route('g-data.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-file-lines fs-3"></i>
                            </span>
                            <span class="menu-title">Data Umum</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('doc-g-data.*') && !Route::is('doc-g-data.onlyTrashed') ? 'active' : '' }}" href="{{route('doc-g-data.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Dokumen Data Umum</span>
                        </a>
                    </div>
                    
                   

                    
                @endif

                @if(Auth::user()->id_group == 3)
                    <div class="menu-item menu-accordion {{ Route::is('doc-prov.*') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-building fs-3"></i>
                            </span>
                            <span class="menu-title">Dokumen Provinsi</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @php
                                $session_date = Session::get('selected_year');
                                // $category = \App\Models\M_Category::all();
                                $categorys = \App\Models\Category_Doc_Provinsi::where('id_survey', $session_date)->get();
                                // dd($session_date);
                            @endphp
                            @foreach($categorys as $category)
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('doc-prov.show') && request()->id == $category->id ? 'active' : '' }}" href="{{ route('doc-prov.show', ['id' => $category->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $category->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(Auth::user()->id_group == 5)
                    <div class="menu-item pt-5"><!--begin:Menu content-->
                        <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Kabupaten/Kota</span>
                        </div><!--end:Menu content-->
                    </div>

                    {{-- <div class="menu-item menu-accordion {{ Route::is('v-pusat.indexGData') || Route::is('v-pusat.indexGData') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Gambaran Umum</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-pusat.indexGData') && request()->id == $zona->id ||
                                        (request()->routeIs('v-pusat.indexGData') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-pusat.indexGData', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                   
                    <div class="menu-item menu-accordion {{ Route::is('v-prov.indexKelembagaan') || Route::is('v-prov.showKelembagaan')  ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-industry fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Data Kelembagaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_Zona::all() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.indexKelembagaan') && request()->id == $zona->id ||
                                        (request()->routeIs('v-prov.showKelembagaan') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-prov.indexKelembagaan', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-prov.indexGData')   ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Dokumen Umum</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_Zona::all() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.indexGData') && request()->id == $zona->id
                                        
                                        ? 'active' : '' }}" href="{{ route('v-prov.indexGData', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}

                    <div class="menu-item menu-accordion {{ Route::is('v-prov.indexGData') || Route::is('v-prov.indexGData') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Gambaran Umum</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.indexGData') && request()->id == $zona->id ||
                                        (request()->routeIs('v-prov.indexGData') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-prov.indexGData', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-prov.indexKelembagaan') || Route::is('v-pusat.showCategory') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Kelembagaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.indexKelembagaan') && request()->id == $zona->id ||
                                        (request()->routeIs('v-prov.showCategory') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-prov.indexKelembagaan', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-prov.indexPendanaan') || Route::is('v-prov.indexPendanaan') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Pendanaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.indexPendanaan') && request()->id == $zona->id ||
                                        (request()->routeIs('v-prov.indexPendanaan') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-prov.indexPendanaan', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="menu-item menu-accordion {{ Route::is('v-prov.index') || Route::is('v-prov.showCategory') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Data Tatanan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.index') && request()->id == $zona->id ||
                                        (request()->routeIs('v-prov.showCategory') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-prov.index', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="menu-item menu-accordion {{ Route::is('v-prov.indexNarasi') || Route::is('v-prov.indexNarasi') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Verifikasi Narasi Tatanan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            @foreach(\App\Models\M_District::where('province_id', 13)->get() as $zona)
                                <div class="menu-item">
                                    <a class="menu-link {{ 
                                        request()->routeIs('v-prov.indexNarasi') && request()->id == $zona->id ||
                                        (request()->routeIs('v-prov.indexNarasi') && request()->id_zona == $zona->id)
                                        ? 'active' : '' }}" href="{{ route('v-prov.indexNarasi', ['id' => $zona->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $zona->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                   


                
                @endif

                @if(Auth::user()->id_group == 6)
                    
                    
                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('g-data.indexKabKota') ? 'active' : '' }}" href="{{route('g-data.indexKabKota')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-file-lines fs-3"></i>
                                {{-- <i class="fa-solid fa-house fs-3"></i> --}}
                            </span>
                            <span class="menu-title">Data Umum</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('doc-g-umum.*') ? 'active' : '' }}" href="{{route('doc-g-umum.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Gambaran Umum</span>
                        </a>
                    </div>

                    <div class="menu-item menu-accordion {{
                            request()->routeIs('kelembagaan.*') ||
                            Route::is('kelembagaan-v2.show') ||
                            Route::is('kelembagaan-v2.editActivity') ||
                            Route::is('kelembagaan-v2.editForumKec') ||
                            Route::is('kelembagaan-v2.createForumKec') ||
                            Route::is('act-kec.createActivityKec') ||
                            Route::is('pokja-desa.showPokjaDesa') ||
                            Route::is('pokja-desa.createSkPokjaDesa') ||
                            Route::is('pokja-desa.editSkPokjaDesa') ||
                            Route::is('pokja-desa.createActivityPokja') ||
                            Route::is('pokja-desa.editActivityPokja')

                            
                            ? 'show' : '' 
                        }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-industry fs-3"></i>
                            </span>
                            <span class="menu-title">Data Kelembagaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion ">
                            @php
                                $session_date = Session::get('selected_year');
                                $categorys = \App\Models\M_C_Kelembagaan_New::where('id_survey', $session_date)->get();
                            @endphp
                            @foreach( $categorys as $data)
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('kelembagaan-v2.show') && request()->id == $data->id ? 'active' : '' }}" href="{{ route('kelembagaan-v2.show', ['id' => $data->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $data->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>  
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('pendanaan-kabkota.*') ? 'active' : '' }}" href="{{route('pendanaan-kabkota.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Pendanaan</span>
                        </a>
                    </div>
                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Route::is('doc-g-data.indexKabKota') ? 'active' : '' }}" href="{{route('doc-g-data.indexKabKota')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Dokumen Data umum</span>
                        </a>
                    </div> --}}
                    
                    <div class="menu-item menu-accordion {{ request()->routeIs('answer-data.*') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book fs-3"></i>
                            </span>
                            <span class="menu-title">Data Tatanan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion ">
                            @php
                                $session_date = Session::get('selected_year');
                                // $category = \App\Models\M_Category::all();
                                $category = \App\Models\M_Category::where('id_survey', $session_date)->get();
                                // dd($session_date);
                            @endphp
                            @foreach($category as $tatanan)
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('answer-data.show') && request()->id == $tatanan->id ? 'active' : '' }}" href="{{ route('answer-data.show', ['id' => $tatanan->id]) }}">
                                        <span class="menu-icon">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $tatanan->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>  
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('narasi-tatanan.index') ? 'active' : '' }}" href="{{route('narasi-tatanan.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Narasi Tatanan</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::is('answer.exportAllCategory') ? 'active' : '' }}" href="{{route('answer.exportAllCategory')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder fs-3"></i>
                            </span>
                            <span class="menu-title">Cetak Tatanan</span>
                        </a>
                    </div>
                    
                @endif
                
            </div>
        </div>
    </div>
</div>
