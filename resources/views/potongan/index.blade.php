@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Potongan
        </h3>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('payrol.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
        {{-- @if (Auth::user()->username == 'admin') --}}
        <a href="{{ route('potongan.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Tambah</a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">

    @include('potongan.table')
  </div>
@endsection
