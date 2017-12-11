@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Hour Meter
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('hour.index') }}" class="btn btn-primary btn-sm">
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
            <label for="karyawan_id">Biodata Karyawan</label>
            <select class="form-control select2 {{ is_invalid($errors, 'karyawan') }}" id="karyawan_id" name="karyawan">
              <option value="">Pilih Driver</option>
              @foreach ($karyawan as $item)
                <option value="{{$item->id}}" {{ old('karyawan_id') == $item->id ? 'selected' : '' }}>{{$item->biodata()->where('id',$item->biodata_id)->value('nama_lengkap')}}</option>
              @endforeach
            </select>
            {!! show_inline_error($errors, 'karyawan') !!}
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'tanggal') }}" name="tanggal" data-toggle="datepicker" id="tanggal" value="{{ old('tanggal') }}">
                {!! show_inline_error($errors, 'tanggal') !!}
              </div>
            </div>
            {{-- <div class="col-md">
              <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'nik') }}" name="nik" id="nik" value="{{ old('nik') }}">
                {!! show_inline_error($errors, 'nik') !!}
              </div>
            </div> --}}
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="shift">Shift</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'shift') }}" name="shift" id="shift" value="{{ old('shift') }}">
                {!! show_inline_error($errors, 'shift') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="unit">Unit</label>
                <select class="form-control {{ is_invalid($errors, 'unit') }}" id="unit" name="unit">
                  <option value="">Pilih Unit</option>
                  @foreach ($alat as $item)
                    <option value="{{$item->id}}" {{ old('unit') == $item->alat_id ? 'selected' : '' }}>{{$item->nama}}</option>
                  @endforeach
                </select>
                {!! show_inline_error($errors, 'unit') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="mulai">Mulai</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control jam" name="mulai" id="mulai" value="{{ old('mulai') }}">
                  <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                </div>
                {!! show_inline_error($errors, 'mulai') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="selesai">Selesai</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control jam" name="selesai" id="selesai" value="{{ old('selesai') }}">
                  <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                </div>
                {!! show_inline_error($errors, 'selesai') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="mulai_des">Mulai</label>
                <input type="text" id="mulai_des" name="mulai_des" value="{{old('mulai_des')}}" class="form-control {{is_invalid($errors,'mulai_des')}}">
                {!! show_inline_error($errors,'mulai_des') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="selesai_des">Selesai</label>
                <input type="text" id="selesai_des" name="selesai_des" value="{{old('selesai_des')}}" class="form-control {{is_invalid($errors,'selesai_des')}}">
                {!! show_inline_error($errors,'selesai_des') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="total_des">Total</label>
                <input type="text" id="total_des" name="total_des" value="{{old('total_des')}}" class="form-control {{is_invalid($errors,'total_des')}}">
                {!! show_inline_error($errors,'total_des') !!}
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
    @include('hour.table')
  </div>
@endsection
