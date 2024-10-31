@extends('partials.index')
@section('heading')
    Dashboard
@endsection
@section('page')
    Dashboard
@endsection


@section('content')
<div class="row">
    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <h3 class="text-custom-primary">
                    DATA TATANAN
                </h3>
                <h1 class="text-custom-secondary">
                    {{$category}}
                </h1>
            </div>
        </div>
    </div>
   
    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <h3 class="text-custom-primary">
                    DATA PERTANYAAN
                </h3>
                <h1 class="text-custom-secondary">
                    {{$questions}}
                </h1>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                <h3 class="text-custom-primary">
                    DATA USER
                </h3>
                <h1 class="text-custom-secondary">
                    {{$user}}
                </h1>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="card w-100 card-custom">
            <div class="card-body">
                {{-- <img src="{{asset('assets/img/icon-payment.svg')}}" alt="" class="mb-4" /> --}}
                <h3 class="text-custom-primary">
                    DATA KABUPATEN/KOTA
                </h3>
                <h1 class="text-custom-secondary">
                    {{$zona}}
                </h1>
            </div>
        </div>
    </div>

</div>
@endsection
