@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Master Departemen
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('master::departemen.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <form action="{{ $action }}" method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="kode">Kode</label>
            <input type="text" style="opacity:0.5" class="form-control {{ is_invalid($errors, 'kode') }}" name="kode" id="kode" value="{{ old('kode') }}">
            {!! show_inline_error($errors, 'kode') !!}
          </div>
          <div class="form-group">
            <label for="nama">Nama Departemen</label>
            <input type="text" style="opacity:0.5" class="form-control {{ is_invalid($errors, 'nama') }}" name="nama" id="nama" value="{{old('nama')}}">
            {!! show_inline_error($errors, 'nama') !!}
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-10"></div>
              <div class="col-md-2">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <hr class="dashed">
    @include('master.departemen.table')
  </div>
@endsection
