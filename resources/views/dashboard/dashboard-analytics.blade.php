@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Pengundian')

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
  <div class="row match-height">
    <!-- Greetings Card starts -->
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card card-congratulations">
        <div class="card-body text-center">
          <img src="{{asset('images/elements/decore-left.png')}}" class="congratulations-img-left"
            alt="card-img-left" />
          <img src="{{asset('images/elements/decore-right.png')}}" class="congratulations-img-right"
            alt="card-img-right" />
          {{-- <div class="avatar avatar-xl bg-primary shadow">
            <div class="avatar-content">
              <i data-feather="award" class="font-large-1"></i>
            </div>
          </div> --}}
          <div class="text-center">
            <br>
            <h1 class="mb-1 text-white">Pengundian Hadiah Vaksinasi</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- Greetings Card ends -->

    @foreach ($hadiah as $item)

    <div class="col-lg-3 col-md-6 col-12">
      <div class="card">
        <img class="card-img p-2" src="{{asset('storage/icon/'.$item->icon)}}" />
        <div class="card-body">
          <h4 class="card-title">{{ $item->hadiah }}</h4>
          @if ($item->pemenang)
          <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">{{ @$item->pemenang->nama }}</h4>
            <div class="alert-body">{{ @$item->pemenang->nik}}</div>
          </div>
          @else
          <form action="{{ route('hadiah.undian') }}" method="get">
            {!! Form::hidden('hadiah', $item->id) !!}
            <button class="btn btn-outline-primary">UNDI</button>
          </form>

          @endif
        </div>
      </div>
    </div>
    @endforeach

  </div>



</section>
<!-- Dashboard Analytics end -->
@endsection

@section('page-script')

@endsection