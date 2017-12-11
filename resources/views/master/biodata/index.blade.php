@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Master Biodata
        </h3>
      </div>
      {{-- <div class="col-md-4"></div> --}}
      @if (Auth::user()->username == 'admin')
        <div class="col-md-6 text-right">
          <a href="{{ route('master::biodata.create') }}" class="btn btn-primary btn-md"><i class="fa fa-plus-circle"></i> Tambah</a>
        </div>
      @endif
    </div>
    <hr class="dashed mt20 mb20">
    <form action="{{route('master::biodata.index')}}" method="get">
    <div class="row">
      <div class="col-md-6"></div>
      <label for="nama" class="col-md-2 col-form-label text-right" style="font-size:20px"> Nama Lengkap</label>
      <div class="col-md-2">
        <select name="nama" id="nama" class="form-control custom-select select2" >
          <option value="">Semua Nama</option>
          @foreach ($biodataAll as $index => $item)
            <option value="{{$item->id}}" {{$item->id == request('nama')?'selected':''}}>{{$item->nama_lengkap}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-filter fa-fw"></i> Filter</button>
      </div>
    </div>
    </form>
    <br>
    @include('master.biodata.table')
  </div>
@endsection
