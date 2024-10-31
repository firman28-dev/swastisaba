@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Pertanyaan</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('q-option.index') }}">
                        <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                            <i class="nav-icon fas fa-arrow-left"></i>Kembali
                        </button>
                    </a>
                    &nbsp;
                    <a href="{{ route('q-option.import',$category->id) }}">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-export"></i>Import Opsi
                        </button>
                    </a>
                    &nbsp;
                    <a href="{{ route('doc-question.import',$category->id) }}">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-export"></i>Import Data Dukung
                        </button>
                    </a>
                </div>
                
            </div>
            
            <div class="table-responsive">

                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border-1 border text-center">No.</th>
                            <th class="border-1 border text-center">ID</th>
                            <th class="border-1 border">Pertanyaan</th>
                            <th class="border-1 border w-200px">#</th>
                            <th class="border-1 border w-200px">#</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $data)
                            <tr>
                                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border-1 border">{{ $data->id }}</td>
                                {{-- <td class="text-capitalize">{{ $data->_category->name }}</td> --}}
                                <td class="text-capitalize border-1 border">{{ $data->name }}</td>
                                {{-- <td class="text-capitalize">{{ $data->s_data }}</td> --}}
                                {{-- <td class="text-capitalize">{{ $data->d_operational }}</td> --}}
                                <td class="border-1 border">
                                    <a href="{{route('showQuestionOpt',$data->id)}}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat opsi
                                    </a>
                                </td>

                                <td class="border-1 border">
                                    <a href="{{route('doc-question.index',$data->id)}}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat data dukung
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        
    </div>
@endsection

@section('script')
    <script>
        $("#tableSKPD").DataTable({
            responsive: true,
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "pageLength" : 100,
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
@endsection
