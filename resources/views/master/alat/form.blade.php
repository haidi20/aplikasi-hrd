@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Master Alat
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('master::alat.index') }}" class="btn btn-primary btn-sm">
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
            <label for="nama">Nama Alat</label>
            <input type="text" class="form-control {{ is_invalid($errors, 'nama') }}" name="nama" id="nama" value="{{ old('nama') }}">
            {!! show_inline_error($errors, 'nama') !!}
          </div>
          <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control {{is_invalid($errors,'kategori')}}">
              <option value="">Pilih Kategori</option>
              <option value="Rental" {{old('kategori') == 'Rental'?'selected':''}}>Rental</option>
              <option value="Hauling" {{old('kategori') == 'Hauling'?'selected':''}}>Hauling</option>
              <option value="Mining" {{old('kategori') == 'Mining'?'selected':''}}>Mining</option>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control {{ is_invalid($errors, 'status') }}" id="status" name="status">
              <option value="">Pilih Status</option>
              <option value="Ya" {{old('status') == 'Ya'?'selected':''}}>Ya</option>
              <option value="Tidak"{{old('status') == 'Tidak'?'selected':''}}>Tidak</option>
            </select>
            {!! show_inline_error($errors, 'status') !!}
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
    @include('master.alat.table')
  </div>
@endsection
