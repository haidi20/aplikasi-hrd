@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Potongan
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('potongan.index') }}" class="btn btn-primary btn-sm">
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
            <label for="tanggal">Tanggal</label>
            <input type="text" id="tanggal" name="tanggal" value="{{old('tanggal')}}" class="form-control {{is_invalid($errors, 'tanggal')}}" data-toggle="datepicker">
            {!! show_inline_error($errors,'tanggal') !!}
          </div>
          <div class="form-group">
            <label for="karyawan">Karyawan</label>
            <select name="karyawan" id="karyawan" class="form-control select2 {{is_invalid($errors,'karyawan')}}">
              <option value="">Pilih Karyawan</option>
              @foreach ($karyawan as $index => $item)
                @if ($item->biodata)
                  <option value="{{$item->id}}" {{old('karyawan_id') == $item->id?'selected':''}}>{{$item->biodata->nama_lengkap}}</option>
                @endif
              @endforeach
            </select>
            {!!show_inline_error($errors,'karyawan')!!}
          </div>
          <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control {{is_invalid($errors, 'kategori')}}">
              <option value="">Pilih Kategori</option>
              <option value="Kasbon" {{old('kategori') == 'Kasbon'?'selected':''}}>Kasbon</option>
              <option value="Lain-lain" {{old('kategori') == 'Lain-lain'?'selected':''}}>Lain-lain</option>
            </select>
            {!! show_inline_error($errors, 'kategori') !!}
          </div>
          <div class="fomr-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" value="{{old('keterangan')}}" class="form-control {{is_invalid($errors,'keterangan')}}">
          </div>
          {!! show_inline_error($errors, 'keterangan') !!}
          <div class="form-group">
            <label for="nominal">Nominal</label>
            <input type="text" name="nominal" id="nominal" value="{{old('nominal')}}" class="form-control {{is_invalid($errors,'nominal')}}">
          </div>
          {!! show_inline_error($errors, 'nominal') !!}
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
    @include('potongan.table')
  </div>
@endsection
