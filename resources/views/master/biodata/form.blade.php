@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Master Biodata
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('master::biodata.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-6 ml-auto mr-auto">
        <form action=" {{$action}} " method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nama_panggilan">Nama Panggilan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'nama_panggilan') }}" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan') }}">
                  {!! show_inline_error($errors, 'nama_panggilan') !!}
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="nama_lengkap">Nama Lengkap</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'nama_lengkap') }}" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}">
                  {!! show_inline_error($errors, 'nama_lengkap') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="nama_depan">Nama Depan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'nama_depan') }}" name="nama_depan" id="nama_depan" value="{{ old('nama_depan') }}">
                  {!! show_inline_error($errors, 'nama_depan') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="nama_belakang">Nama Belakang</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'nama_belakang') }}" name="nama_belakang" id="nama_belakang" value="{{ old('nama_belakang') }}">
                  {!! show_inline_error($errors, 'nama_belakang') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="tempat_lahir">Tempat Lahir</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'tempat_lahir') }}" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}">
                  {!! show_inline_error($errors, 'tempat_lahir') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="tanggal_lahir">Tanggal Lahir</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'tanggal_lahir') }}" name="tanggal_lahir" id="tanggal_lahir" data-toggle="datepicker" value="{{ old('tanggal_lahir') ? old('tanggal_lahir'): '01/01/1990' }}">
                  {!! show_inline_error($errors, 'tanggal_lahir') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="status">Status</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'status') }}" name="status" id="status" value="{{ old('status') }}">
                  {!! show_inline_error($errors, 'status') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="agama">Agama</label>
                  <select class="form-control custom-select {{ is_invalid($errors, 'agama') }}" id="agama" name="agama">
                    <option value="">Pilih Agama</option>
                    @foreach ($listAgama as $agama)
                      <option value="{{$agama}}" {{ old('agama') == $agama ? 'selected' : '' }}>{{$agama}}</option>
                    @endforeach
                  </select>
                  {!! show_inline_error($errors, 'agama') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="ktp">KTP</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'ktp') }}" name="ktp" id="ktp" value="{{ old('ktp') }}">
                  {!! show_inline_error($errors, 'ktp') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="akhir_ktp">Tanggal Masa Aktif KTP</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'akhir_ktp') }}" name="akhir_ktp" id="akhir_ktp" data-toggle="datepicker" value="{{ old('akhir_ktp') }}">
                  {!! show_inline_error($errors, 'akhir_ktp') !!}
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat KTP</label>
              <textarea name="alamat" id="alamat" rows="3" class="form-control {{ is_invalid($errors, 'alamat') }}">{{ old('alamat') }}</textarea>
              {!! show_inline_error($errors, 'alamat') !!}
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input type="radio" id="wni" name="warganegara" value="wni" {{old('warganegara') == 'wni'?'checked':''}}>WNI </label>
                  <label><input type="radio" id="wna" name="warganegara" value="wna" {{old('warganegara') == 'wna'?'checked':''}}>WNA</label>
                  {!! show_inline_error($errors,'warganegara') !!}
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label for="kewarganegaraan">Kewarganegaraan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'kewarganegaraan') }}" name="kewarganegaraan" id="kewarganegaraan" value="{{ old('kewarganegaraan') }}">
                  {!! show_inline_error($errors, 'kewarganegaraan') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="rt">RT</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'rt') }}" name="rt" id="rt" value="{{ old('rt') }}">
                  {!! show_inline_error($errors, 'rt') !!}
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="rw">RW</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'rw') }}" name="rw" id="rw" value="{{ old('rw') }}">
                  {!! show_inline_error($errors, 'rw') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="kota">Kota</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'kota') }}" name="kota" id="kota" value="{{ old('kota') }}">
                  {!! show_inline_error($errors, 'kota') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="status_rumah">Status Rumah</label>
                  <select name="status_rumah" id="status_rumah" class="form-control {{is_invalid($errors, 'status_rumah')}}">
                    <option value="">Pilih Status Rumah</option>
                    <option value="Pribadi" {{old('status_rumah') == 'Pribadi'?'selected':''}}>Pribadi</option>
                    <option value="Milik Orang Tua" {{old('status_rumah') == 'Milik Orang Tua'?'selected':''}}>Milik Orang Tua</option>
                    <option value="Kontrak" {{old('status_rumah') == 'Kontrak'?'selected':''}}>Kontrak</option>
                  </select>
                  {!! show_inline_error($errors, 'status_rumah') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="kecamatan">Kecamatan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'kecamatan') }}" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}">
                  {!! show_inline_error($errors, 'kecamatan') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="kelurahan">Kelurahan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'kelurahan') }}" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}">
                  {!! show_inline_error($errors, 'kelurahan') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="pendidikan">Pendidikan Terakhir</label>
                  <select class="form-control custom-select {{ is_invalid($errors, 'pendidikan') }}" id="pendidikan" name="pendidikan">
                    <option value="">Pilih Pendidikan</option>
                    @foreach ($listPendidikan as $pendidikan)
                      <option value="{{$pendidikan}}" {{ old('pendidikan') == $pendidikan ? 'selected' : '' }}>{{$pendidikan}}</option>
                    @endforeach
                  </select>
                  {!! show_inline_error($errors, 'pendidikan') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="instansi_pendidikan">Instansi Pendidikan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'instansi_pendidikan') }}" name="instansi_pendidikan" id="instansi_pendidikan" value="{{ old('instansi_pendidikan') }}">
                  {!! show_inline_error($errors, 'instansi_pendidikan') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="jurusan">Jurusan</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'jurusan') }}" name="jurusan" id="jurusan" value="{{ old('jurusan') }}">
                  {!! show_inline_error($errors, 'jurusan') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="tahun_masuk">Tahun Masuk</label>
                  <select name="tahun_masuk" id="tahun_masuk" class="form-control {{ is_invalid($errors,'tahun_masuk')}}">
                    <option value="">Pilih Tahun</option>
                    @for ($date=$mulai->copy(); $date->diffInYears($akhir); $date->addYear())
                      <option value="{{$date->format('Y')}}" {{old('tahun_masuk') == $date->format('Y')?'selected':''}}>{{$date->format('Y')}}</option>
                    @endfor
                  </select>
                  {!! show_inline_error($errors, 'tahun_masuk') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="tahun_kelulusan">Tahun Kelulusan</label>
                  <select name="tahun_kelulusan" id="tahun_kelulusan" class="form-control {{ is_invalid($errors,'tahun_kelulusan')}}">
                    <option value="">Pilih Tahun</option>
                    @for ($date=$mulai->copy(); $date->diffInYears($akhir); $date->addYear())
                      <option value="{{$date->format('Y')}}" {{old('tahun_kelulusan') == $date->format('Y')?'selected':''}}>{{$date->format('Y')}}</option>
                    @endfor
                  </select>
                  {!! show_inline_error($errors, 'tahun_kelulusan') !!}
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="nilai_akhir">Nilai Akhir</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'nilai_akhir') }}" name="nilai_akhir" id="nilai_akhir" value="{{ old('nilai_akhir') }}">
                  {!! show_inline_error($errors, 'nilai_akhir') !!}
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
          </div>
        </form>
      </div>
      @include('master.biodata.table')
    </div>
  </div>
@endsection
