@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Pengaturan
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('pengaturan.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-7 ml-auto mr-auto">
        <form action="{{ $action }}" method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          @if (Session::get('note'))
            <div class="alert alert-success">
              {{Session::get('note')}}
            </div>
          @endif
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="biasa">Anggaran Trip 1 - 4</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'anggaran_trip_1_-_4') }}" name="anggaran_trip_1_-_4" id="biasa" value="{{ old('biasa') }}">
                {!! show_inline_error($errors, 'anggaran_trip_1_-_4') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="lumayan">Anggaran Trip 5 dan seterusnya</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'anggaran_trip_5_dan_seterusnya') }}" name="anggaran_trip_5_dan_seterusnya" id="lumayan" value="{{ old('lumayan') }}">
                {!! show_inline_error($errors, 'anggaran_trip_5_dan_seterusnya') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="bonus">Bonus Anggaran Jumlah Trip 120</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'Bonus_Anggaran') }}" name="Bonus_Anggaran" id="bonus" value="{{ old('bonus') }}">
                {!! show_inline_error($errors, 'Bonus_Anggaran') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="pph21">PPH 21</label>
                <input type="text" name="pph21" id="pph21" class="form-control {{is_invalid($errors, 'pph21')}}" value="{{old('pph21')}}">
                {!! show_inline_error($errors, 'pph21') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="jam_alat">Batas Jam Alat</label>
                <input type="jam_alat" id="jam_alat" name="jam_alat" class="form-control {{is_invalid($errors,'jam_alat')}}" value="{{old('jam_alat')}}">
                {!! show_inline_error($errors,'jam_alat') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="alat_spesial">Alat Spesial</label>
                <input type="text" name="alat_spesial" id="alat_spesial" class="form-control {{is_invalid($errors, 'alat_spesial')}}" value="{{old('alat_spesial')}}">
                {!! show_inline_error($errors, 'alat_spesial') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="alat_biasa">Alat Biasa</label>
                <input type="text" name="alat_biasa" id="alat_biasa" class="form-control {{is_invalid($errors, 'alat_biasa')}}" value="{{old('alat_biasa')}}">
                {!! show_inline_error($errors, 'alat_biasa') !!}
              </div>
            </div>
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
    @include('pengaturan.table')
  </div>
@endsection
