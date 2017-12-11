@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Pengaturan Nominal Absen
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('setabsen.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-5 ml-auto mr-auto">
        <form action="{{ $action }}" method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="text" id="tanggal" name="tanggal" value="{{old('tanggal')}}" class="form-control {{is_invalid($errors, 'tanggal')}}" data-toggle="datepicker">
            {!! show_inline_error($errors,'tanggal') !!}
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="ijin_resmi">Ijin Resmi</label>
                <input type="text" id="ijin_resmi" name="ijin_resmi" value="{{old('ir')}}" class="form-control {{is_invalid($errors,'ijin_resmi')}}">
                {!! show_inline_error($errors,'ijin_resmi') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="ijin_tidak_resmi">Ijin Tidak Resmi</label>
                <input type="text" id="ijin_tidak_resmi" name="ijin_tidak_resmi" value="{{old('i')}}" class="form-control {{is_invalid($errors,'ijin_tidak_resmi')}}">
                {!! show_inline_error($errors,'ijin_tidak_resmi') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="sakit_surat_dokter">Sakit Surat Dokter</label>
                <input type="text" id="sakit_surat_dokter" name="sakit_surat_dokter" value="{{old('s')}}" class="form-control {{is_invalid($errors,'sakit_surat_dokter')}}">
                {!! show_inline_error($errors,'sakit_surat_dokter') !!}
              </div>
            </div>
            <div class="form-group">
              <label for="sakit_tanpa_surat">Sakit Tanpa Surat</label>
              <input type="text" id="sakit_tanpa_surat" name="sakit_tanpa_surat" value="{{old('s1')}}" class="form-control {{is_invalid($errors,'sakit_tanpa_surat')}}">
              {!! show_inline_error($errors,'sakit_tanpa_surat') !!}
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="alpha">Alpha</label>
                <input type="text" id="alpha" name="alpha" value="{{old('a')}}" class="form-control {{is_invalid($errors,'alpha')}}">
                {!! show_inline_error($errors,'alpha') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="baru/keluar">Baru/keluar</label>
                <input type="text" id="baru/keluar" name="baru/keluar" value="{{old('x')}}" class="form-control {{is_invalid($errors,'baru/keluar')}}">
                {!! show_inline_error($errors,'baru/keluar') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="setengah_hari">Setengah Hari</label>
                <input type="text" id="setengah_hari" name="setengah_hari" value="{{old('mi')}}" class="form-control {{is_invalid($errors,'setengah_hari')}}">
                {!! show_inline_error($errors,'setengah_hari') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="cuti">Cuti</label>
                <input type="text" id="cuti" name="cuti" value="{{old('ct')}}" class="form-control {{is_invalid($errors,'cuti')}}">
                {!! show_inline_error($errors,'cuti') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="libur_nasional">Libur Nasional</label>
                <input type="text" id="libur_nasional" name="libur_nasional" value="{{old('l')}}" class="form-control {{is_invalid($errors,'libur_nasional')}}">
                {!! show_inline_error($errors,'libur_nasional') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="minggu">Minggu</label>
                <input type="text" id="minggu" name="minggu" value="{{old('m')}}" class="form-control {{is_invalid($errors,'minggu')}}">
                {!! show_inline_error($errors,'minggu') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="off">OFF</label>
                <input type="text" id="off" name="off" value="{{old('off')}}" class="form-control {{is_invalid($errors,'off')}}">
                {!! show_inline_error($errors,'off') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="lembur">Lembur</label>
                <input type="text" id="lembur" name="lembur" value="{{old('lembur')}}" class="form-control {{is_invalid($errors, 'lembur')}}">
              </div>
            </div>
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
    @include('setabsen.table')
  </div>
@endsection
