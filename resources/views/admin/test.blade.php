@extends('partials.index')
@section('heading')
    Testing Kab/Kota
@endsection
@section('page')
    Data Testing Kab/Kota
@endsection


@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-body">
        <form action="{" method="POST">
            @csrf
            <h2>{{ $test->name }}</h2>
        
            @foreach ($test->_question as $pertanyaan)
                <div class="form-group mb-3">
                    <label>{{ $pertanyaan->name }}</label>
                    @foreach ($pertanyaan->_q_option as $opsi)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="jawaban[{{ $pertanyaan->id }}]" value="{{ $opsi->id }}">
                            <label class="form-check-label">{{ $opsi->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        
            <button type="submit" class="btn btn-primary btn-sm mt-4">Submit</button>
        </form>
    </div>
    
</div>

@endsection

