@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Pengaturan
        </h3>
      </div>
      {{-- @if (Auth::user()->username == 'admin') --}}
      <div class="col-md-6 text-right">
        <a href="{{ route('pengaturan.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Tambah</a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">

    @include('pengaturan.table')
  </div>
@endsection
