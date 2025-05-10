@extends('partials.index')
@section('heading')
    {{$zona->name}}
@endsection
@section('page')
    Data Kelembagaan
@endsection


@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Kelembagaan</h3>
            </div>
        </div>
        <div class="card-body">
            <button class="btn btn-success btn-outline btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cetak">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-print"></i> Cetak
                </div>
            </button>
            <div class="modal fade modal-dialog-scrollable" tabindex="-1" id="cetak" data-bs-backdrop="static" data-bs-keyboard="false">
                                    
                <div class="modal-dialog modal-dialog-scrollable">
                    <form action="{{ route('v-prov.printAllKelembagaan')}}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">
                                    Input Berita Acara
                                </h3>
                            </div>
                            <div class="modal-body">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Tahun</label>
                                            <input type="text" value="{{ $tahun->trans_date }}"  readonly class="form-control form-control-solid rounded rounded-4">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Nama Kab/Kota</label>
                                            <input type="text" value="{{ $zona->name  }}" readonly class="form-control form-control-solid rounded rounded-4">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Nama Penanggungjawab Kab/Kota</label>
                                            <input type="text" required class="form-control form-control-solid rounded rounded-4" id="pembahas" name="pembahas" placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Jabatan Penanggungjawab Kab/Kota</label>
                                            <input type="text"  required class="form-control form-control-solid rounded rounded-4" id="jabatan" name="jabatan" placeholder="Jabatah">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group w-100">
                                            <label for="achievement" class="form-label">Tim Verifikasi Provinsi</label>
                                            <input type="text" required class="form-control form-control-solid rounded rounded-4" id="operator" name="operator" placeholder="Nama">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="tahun" value="{{ $tahun->id }}">
                                <input type="hidden" name="kota" value="{{ $zona->id}}">
                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal" onclick="location.reload()">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-4">Cetak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1 text-center p-3">No.</th>
                            <th class="border border-1">Nama Kategori Kelembagaan</th>
                            <th class="border border-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $data)
                            <tr>
                                <td class="border border-1 text-center p-3">{{ $loop->iteration }}</td>
                                <td class="text-capitalize border border-1 p-3">{{ $data->name }}</td>
                                <td class="border border-1 p-3">
                                    <a href="{{route('v-prov.showKelembagaan',['id_zona' => $zona->id, 'id' => $data->id]) }}" class="btn btn-outline btn-outline-success btn-sm">
                                        Lihat Pertanyaan
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
