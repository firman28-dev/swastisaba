@extends('partials.index')
@section('heading')
    {{$zona->name}}
@endsection
@section('page')
    Dokumen Umum
@endsection


@section('content')
   

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>Daftar Dokumen Umum</h3>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('v-prov.indexKelembagaan', $zona->id)}}">
                <button type="button" class="btn btn-primary btn-outline btn-outline-primary btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>Kembali
                </button>
            </a>
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted text-center ">
                            <th class="w-60px text-center border-1 border align-middle p-3">No.</th>
                            <th class="w-150px text-center border-1 border align-middle p-3">Nama Dokumen </th>
                            <th class="w-100px text-center border-1 border align-middle p-3">Bukti</th>
                            <th class="w-150px text-center border-1 border align-middle p-3">Assesment Provinsi</th>
                            <th class="w-150px text-center border-1 border align-middle p-3">Assesment Pusat</th>
                            <th class=" w-100px text-center border-1 border align-middle p-3">Aksi</th>
                        </tr>
                        
                    </thead>
                   <tbody>
                        @foreach ($category as $item)
                        <tr>
                            <td class="border-1 border text-center p-3">{{$loop->iteration}}</td>
                            <td class="border-1 border p-3">{{ $item->name }}</td>
                            @php
                                $answerDoc = $doc->where('id_doc_g_data', $item->id)->first();
                            @endphp
                            @if ($answerDoc)
                                <td class="border-1 border p-3 text-center">
                                    <a href="{{ asset($answerDoc->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                        <div class="d-flex justify-content-center">
                                            <i class="fa-solid fa-eye"></i>
                                        </div>
                                    </a>
                                </td>
                                <td class="border-1 border p-3 text-center">
                                    @if($answerDoc && $answerDoc->is_prov)
                                        @if ($answerDoc->is_prov == 1)
                                            Sesuai
                                        @else
                                            Tidak sesuai
                                        @endif
                                    @else
                                        <div class="badge badge-light-info">Belum dijawab</div>
                                    @endif
                                </td>

                                <td class="border-1 border p-3 text-center">
                                    @if($answerDoc && $answerDoc->is_pusat)
                                        @if ($answerDoc->is_pusat == 1)
                                            Sesuai
                                        @else
                                            Tidak sesuai
                                        @endif
                                    @else
                                        <div class="badge badge-light-info">Belum dijawab</div>
                                    @endif
                                </td>
                            @else
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Belum diupload</div>
                                </td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Tidak ada</div>
                                </td>
                                <td class="border-1 border text-center p-3">
                                    <div class="badge badge-light-danger">Tidak ada</div>
                                </td>
                            @endif
                            <td class="text-center p-3 border border-1">
                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmUpdate{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                                <div class="modal fade" tabindex="-1" id="confirmUpdate{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <form action="{{ route('v-prov.storeGdata', ['id_zona' => $zona->id, 'id' => $item->id])}}" method="POST">
                                        @csrf
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        Verifikasi Dokumen Umum
                                                    </h3>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p><strong>{{$item->name}}</strong></p>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="is_prov" id="optionAda" value="1" {{ isset($answerDoc) && $answerDoc->is_prov == 1 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="optionAda">Sesuai</label>
                                                    </div>
                                            
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="is_prov" id="optionTidakAda" value="2" {{ isset($answerDoc) && $answerDoc->is_prov == 2 ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="optionTidakAda">Tidak Sesuai</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary rounded-4">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                   </tbody>
                </table>
            </div>
        </div>
        
    </div>

    <!-- Confirmation Modal -->
    <!-- Toast notifikasi sukses -->

@endsection

@section('script')
    <script>

        $("#tableSKPD").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "pageLength":100,
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
