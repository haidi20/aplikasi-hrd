@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Hauling-Trip
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('hauling.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-6 ml-auto mr-auto">
        <form action="{{ $action }}" method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="karyawan_id">Nama Karyawan</label>
            <select class="form-control select2 {{ is_invalid($errors, 'karyawan') }}" id="karyawan_id" name="karyawan">
              <option value="">Pilih Driver</option>
              @foreach ($karyawan as $index => $item)
                @if ($item->biodata)
                  <option value="{{$item->id}}" {{$item->id == old('karyawan_id')?'selected':''}}>{{$item->biodata->nama_lengkap}}</option>
                @endif
              @endforeach
            </select>
            {!! show_inline_error($errors, 'karyawan') !!}
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'tanggal') }}" name="tanggal" id="tanggal" data-toggle="datepicker" value="{{ old('tanggal') }}">
                {!! show_inline_error($errors, 'tanggal') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="shift">Shift</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'shift') }}" name="shift" id="shift" value="{{ old('shift') }}">
                {!! show_inline_error($errors, 'shift') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'tipe') }}" name="tipe" id="tipe" value="{{ old('tipe') }}">
                {!! show_inline_error($errors, 'tipe') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="seam">Kode Seam</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'seam') }}" name="seam" id="seam" value="{{ old('seam') }}">
                {!! show_inline_error($errors, 'seam') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="trip">TRIP</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'trip') }}" name="trip" id="trip" value="{{ old('trip') }}">
                {!! show_inline_error($errors, 'trip') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="pembayaran">Pembayaran</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'pembayaran') }}" name="pembayaran" id="pembayaran" value="{{ old('pembayaran') }}">
                {!! show_inline_error($errors, 'pembayaran') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="unit">Unit</label>
                <select name="unit" id="unit" class="form-control {{is_invalid($errors,'unit')}}">
                  <option value="">Pilih Unit</option>
                  @foreach ($alat as $index => $item)
                    <option value="{{$item->id}}" {{old('alat_id') == $item->id?'selected':''}}>{{$item->nama}}</option>
                  @endforeach
                </select>
                {!! show_inline_error($errors, 'unit') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="jarak">Jarak</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'jarak') }}" name="jarak" id="jarak" value="{{ old('jarak') }}">
                {!! show_inline_error($errors, 'jarak') !!}
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
    @include('hauling.table')
  </div>
@endsection
