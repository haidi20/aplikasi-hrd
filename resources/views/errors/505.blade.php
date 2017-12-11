@extends('_layout.default')
@section('content')
  <div class="container">
    <div class="row">
      <div class="hero-unit center">
        <h1><small><font face="Tahoma" color="red">Not Found</font></small></h1>
        <br/>
        <p>Data Slip Kosong.</p>
        <a href="{{route('pemberitahuan.index')}}" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
      </div>
    </div>
  </div>
@endsection
