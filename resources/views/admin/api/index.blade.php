@extends('partials.index')
@section('heading')
    Data List API
@endsection
@section('page')
    Data List API
@endsection


@section('content')
    <div class="row mb-5">
        <div class="col-lg-6">
            <div class="card w-100 card-custom">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="flex-column">
                            <h1 class="text-custom-primary">
                                ODF
                            </h1>
                            <a href="{{route('api.sendodfAllKabkota')}}" class="btn btn-outline btn-outline-primary btn-sm kirim-btn" 
                                data-href="{{route('api.sendodfAllKabkota')}}"
                            >
                                <span class="btn-text">Kirim</span>
                                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status"></div>
                            </a>
                        </div>
                        <img src="{{asset('assets/img/icon/category.svg')}}" alt="" class="mb-4" />
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card w-100 card-custom">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="flex-column ">
                            <h1 class="text-custom-primary">
                                KELEMBAGAAN
                            </h1>
                            <a href="{{route('api.viewCapaiankelembagaan2024')}}" class="btn btn-outline btn-outline-primary btn-sm kirim-btn"
                                data-href="{{route('api.viewCapaiankelembagaan2024')}}"
                            >
                                <span class="btn-text">Kirim</span>
                                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status"></div>
                            </a>
                        </div>
                        <img src="{{asset('assets/img/icon/category.svg')}}" alt="" class="mb-4" />
                    </div>
                    
                </div>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-12">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        <h3>Daftar Kab Kota Yang Verifikasi</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                            <thead>
                                <tr class="fw-semibold fs-6 text-muted">
                                    <th class="w-60px border-1 border text-center">No.</th>
                                    <th class="w-50  border-1 border">Nama Kabupaten Kota</th>
                                    <th class="border-1 border">Kirim Capaian Ke Pusat</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($districts as $item)
                                    <tr>
                                        <td class="text-center border border-1">{{$loop->iteration }}</td>
                                        <td class="border border-1">{{$item->name }}</td>
                                        <td>
                                            <form action="{{ route('api.viewTatananPerkabkota2024') }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline btn-outline-primary">
                                                    Kirim
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        $("#tableSKPD").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "pageLength":25,
            "dom":
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
    <script>
        document.querySelectorAll('.kirim-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const spinner = this.querySelector('.spinner-border');
                const text = this.querySelector('.btn-text');

                spinner.classList.remove('d-none');
                this.setAttribute('disabled', true);
                text.textContent = 'Mengirim...';

                // Redirect setelah loading aktif
                window.location.href = this.getAttribute('data-href');
            });
        });
    </script>

@endsection
