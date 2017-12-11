@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Waktu-Hauling
        </h3>
      </div>
      {{-- <div class="col-md-4"></div> --}}
      @if (Auth::user()->username == 'admin')
        <div class="col-md-6 text-right">
          <a href="{{route('hauling.index')}}" class="btn btn-primary btn-md">
            <i class="fa fa-reply"></i> Kembali
          </a>
          <a href="{{route('waktu-hauling.create')}}" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tambah</a>
        </div>
      @endif
    </div>
    <hr class="dashed mt20 mb20">
    <br>
    @include('waktu.table')
  </div>
@endsection
