@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>Pengaturan Email</h3>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{route('setemail.create')}}" class="btn btn-primary btn-md">
          <i class="fa fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    @include('mail.table')
  </div>
@endsection
