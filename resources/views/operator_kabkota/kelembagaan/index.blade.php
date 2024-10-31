@extends('partials.index')
@section('heading')
    Pertanyaan Kelembagaan
@endsection
@section('page')
    Data  Kelembagaan
@endsection

@section('content')

    <div class="card mb-5 mb-xl-10">
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h3>{{$category->name}}</h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="tableSKPD" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th class="w-60px border border-1 p-3 text-center">No.</th>
                            <th class="w-150px border border-1">Bagian</th>
                            <th class="w-200px border border-1">Opsi</th>
                            <th class="w-150px border border-1">Jawaban</th>
                            <th class="w-100px border border-1">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($q_kelembagaan as $data)
                            <tr>
                                <td class="border border-1 p-3 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-1 p-3">{{ $data->question }}</td>
                                <td class="border border-1 p-3">{{ $data->opsi }}</td>
                                @php
                                    $answer_v2 = $answer->where('id_q_kelembagaan', $data->id)->first();
                                    $doc_v2 = $doc->where('id_q_kelembagaan', $data->id)->first();
                                @endphp
                                {{-- @if ($answer_v2)
                                    <td>{{$answer_v2->id}}</td>
                                @else
                                    <td>no</td>
                                @endif --}}
                                @if ($answer_v2)
                                    <td class="border border-1 p-3">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                @if ($answer_v2->answer == 1)
                                                    Ada
                                                @else
                                                    Tidak Ada
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmCreate{{ $answer_v2->id }}">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </div>
                                                </button>
                                                <div class="modal fade" tabindex="-1" id="confirmCreate{{ $answer_v2->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                                    <form action="{{ route('kelembagaan.update', $answer_v2->id) }}" method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">
                                                                        Silahkan Isi Jawaban
                                                                    </h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{$data->opsi}}</p>
                                                                    <div class="form-check mb-3">
                                                                        <input class="form-check-input" type="radio" name="answer" id="optionAda" value="1" {{ $answer_v2->answer == 1 ? 'checked' : ''}}>
                                                                        <label class="form-check-label" for="optionAda">Ada</label>
                                                                    </div>
                                                            
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="answer" id="optionTidakAda" value="2" {{ $answer_v2->answer == 2 ? 'checked' : ''}}>
                                                                        <label class="form-check-label" for="optionTidakAda">Tidak Ada</label>
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
                                               
                                            </div>
                                        </div>
                                        
                                    </td>
                                @else
                                    <td class="border border-1 p-3">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="badge badge-light-danger">Belum dijawab</div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmCreate{{ $data->id }}">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </div>
                                                </button>
                                                <div class="modal fade" tabindex="-1" id="confirmCreate{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
                                                    <form action="{{ route('kelembagaan.store', $data->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">
                                                                        Silahkan Isi Jawaban
                                                                    </h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{$data->opsi}}</p>
                                                                    <input name="id_survey" value="{{session('selected_year')}}" hidden>
                                                                    <div class="form-check mb-3">
                                                                        <input class="form-check-input" type="radio" name="answer" id="optionAda" value="1">
                                                                        <label class="form-check-label" for="optionAda1">Ada</label>
                                                                    </div>
                                                            
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="answer" id="optionTidakAda" value="2">
                                                                        <label class="form-check-label" for="optionTidakAda2">Tidak Ada</label>
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
                                               
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                
                                @if ($answer_v2)
                                    
                                    @if ($answer_v2->answer == 2)
                                        <td class="border border-1 p-3">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="badge badge-light-danger">Dokumen tidak ada</div>
                                                </div>
                                            </div>
                                        </td>
                                    @elseif ($answer_v2->answer == 1)
                                        <td class="border border-1 p-3">
                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    @if ($doc_v2)
                                                        <div class="badge badge-light-success">Sudah upload</div>
                                                    @else
                                                        <div class="badge badge-light-danger">Belum upload</div>
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    @if (is_null($doc_v2))
                                                        <!-- Show upload button -->
                                                        <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#createModal{{$data->id}}">
                                                            <div class="d-flex justify-content-center">
                                                                <i class="fa-solid fa-square-plus"></i>
                                                            </div>
                                                        </button>
                                                        <!-- Upload Modal -->
                                                        <div class="modal fade" tabindex="-1" id="createModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
                                                            <form action="{{route('kelembagaan.storeDoc', $data->id)}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 class="modal-title">Input Dokumen Kelembagaan</h3>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input name="id_survey" value="{{session('selected_year')}}" hidden>
                                                                            <div class="col-lg-12">
                                                                                <div class="form-group w-100">
                                                                                    <label for="name" class="form-label">Dokumen</label>
                                                                                    <p class="text-danger">Dokumen berbentuk Pdf dan maksimal 2 MB</p>
                                                                                    <input type="file" name="path" class="form-control form-control-solid rounded rounded-4" placeholder="File">
                                                                                    @error('path')
                                                                                        <div class="is-invalid">
                                                                                            <span class="text-danger">{{$message}}</span>
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
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
                                                    @else
                                                        <!-- Show view and delete buttons -->
                                                        <a href="{{ asset($doc_v2->path) }}" target="_blank" class="btn btn-icon btn-success w-35px h-35px mb-sm-0 mb-3">
                                                            <div class="d-flex justify-content-center">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </div>
                                                        </a>
                                                        <button class="btn btn-icon btn-danger w-35px h-35px mb-sm-0 mb-3" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $doc_v2->id }}">
                                                            <div class="d-flex justify-content-center">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </div>
                                                        </button>
                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" tabindex="-1" id="confirmDelete{{ $doc_v2->id }}">
                                                            <form action="{{ route('kelembagaan.destroyDoc', $doc_v2->id) }}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 class="modal-title">Hapus Data</h3>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Apakah yakin ingin menghapus data dokumen?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit" class="btn btn-primary rounded-4">Hapus</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    
                                    @endif
                                @else
                                    <td class="border border-1 p-3">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="badge badge-light-danger">Belum upload</div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary w-35px h-35px mb-sm-0 mb-3" disabled>
                                                    <div class="d-flex justify-content-center">
                                                        <i class="fa-solid fa-square-plus"></i>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                
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
