@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Master Keluarga
        </h3>
      </div>
      @if (Auth::user()->username == 'admin')
        <div class="col-md-6 text-right">
          <a href="{{ route('master::biodata.index') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-reply"></i> Kembali
          </a>
          <a href="{{ route('master::keluarga.create',['biodata_id'=>request('biodata_id')])}}" class="btn btn-success btn-sm">
            <i class="fa fa-plus-circle"></i> Tambah
          </a>
        </div>
      @endif
    </div>
    <hr class="dashed mt20 mb20">

    @include('master.keluarga.table')
  </div>
@endsection
