@extends('partials.index')
@section('heading')
    Pertanyaan
@endsection
@section('page')
    Data Pertanyaan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableSKPD" class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px">No.</th>
                            <th class="w-300px">Pertanyaan</th>
                            <th>Nilai Self Assesment</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($answer->_question as $pertanyaan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $pertanyaan->name }}</td>
                                <td>
                                    @foreach($pertanyaan->_q_option as $opsi)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="{{ $pertanyaan->id }}" id="{{ $opsi->id }}" value="{{ $opsi->id }}" required>
                                        <label class="form-check-label" for="{{ $opsi->id }}">{{ $opsi->name }}</label>
                                      </div>

                                    @endforeach
                                </td>
                                <td>
                                    @foreach($pertanyaan->_q_option as $opsi)
                                    <div class="mb-3">
                                        {{$opsi->score}}
                                    </div>
                                    @endforeach
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

