@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Master Karyawan
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('master::karyawan.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">

    <div class="row">
      <div class="col-md-6 ml-auto mr-auto">
        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="biodata_id">Biodata Karyawan</label>
                <select class="form-control select2 {{ is_invalid($errors, 'biodata_id') }}" id="biodata_id" name="biodata_id">
                  <option value="">Pilih Nama</option>
                  @foreach ($biodata as $item)
                    <option value="{{$item->id}}" {{ old('biodata_id') == $item->id ? 'selected' : '' }}>{{$item->nama_lengkap}}</option>
                  @endforeach
                </select>
                {!! show_inline_error($errors, 'biodata_id') !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Pilih File Foto</label>
                <input id="input-1" type="file" class="file" name="foto">
                {!! show_inline_error($errors, 'foto') !!}
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="nama_atasan">Nama Atasan</label>
            <input type="text" id="nama_atasan" name="nama_atasan" class="form-control {{ is_invalid($errors,'nama_atasan')}}" value="{{old('nama_atasan')}}">
            {!! show_inline_error($errors, 'nama_atasan') !!}
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="departemen_id">Departemen</label>
                <select class="form-control {{ is_invalid($errors, 'departemen_id') }}" id="departemen_id" name="departemen_id">
                  <option value="">Pilih Departemen</option>
                  @foreach ($departemen as $item)
                    <option value="{{$item->id}}" {{old('departemen_id') == $item->id ? 'selected' : '' }}>{{$item->nama}}</option>
                  @endforeach
                </select>
                {!! show_inline_error($errors, 'departemen_id') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="col-md">
                <div class="form-group ">
                  <label for="jabatan_id">Jabatan</label>
                  <select class="form-control {{ is_invalid($errors, 'jabatan_id') }}" id="jabatan_id" name="jabatan_id">
                    <option value="">Pilih Jabatan</option>
                    @foreach ($jabatan as $item)
                      <option value="{{$item->id}}" {{ old('jabatan_id') == $item->id ? 'selected' : '' }}>{{$item->nama}}</option>
                    @endforeach
                  </select>
                  {!! show_inline_error($errors, 'jabatan_id') !!}
                </div>
              </div>
            </div>
            <div class="col-md">
              <div class="form-group ">
                <label for="divisi">Divisi</label>
                <input type="text" id="divisi" name="divisi" class="form-control {{ is_invalid($errors,'divisi')}}" value="{{old('divisi')}}">
                {!! show_inline_error($errors, 'divisi') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group ">
                <label for="site_id">Site</label>
                <select class="form-control {{ is_invalid($errors, 'site_id') }}" id="site_id" name="site_id">
                  <option value="">Pilih Site</option>
                  @foreach ($site as $item)
                    <option value="{{$item->id}}" {{ old('site_id') == $item->id ? 'selected' : '' }}>{{$item->lokasi}}</option>
                  @endforeach
                </select>
                {!! show_inline_error($errors, 'site_id') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="golongan">Golongan Darah</label>
                <select name="golongan" id="golongan" class="form-control {{is_invalid($errors,'golongan')}}">
                  <option value="">Pilih Golongan Darah</option>
                  <option value="O" {{ old('golongan') == 'O'?'selected':''}}>O</option>
                  <option value="A" {{ old('golongan') == 'A' ?'selected':''}}>A</option>
                  <option value="AB" {{ old('golongan') == 'AB' ?'selected':''}}>AB</option>
                  <option value="B" {{ old('golongan') == 'B' ?'selected':''}}>B</option>
                </select>
                {!! show_inline_error($errors, 'golongan') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control {{ is_invalid($errors, 'status')}}">
                  <option value="">Pilih Status</option>
                  <option value="Ya" {{ old('status') == 'Ya'?'selected':''}}>Ya</option>
                  <option value="Tidak" {{ old('status') == 'Tidak'?'selected':''}}>Tidak</option>
                </select>
                {!! show_inline_error($errors, 'status') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="gapok">Gapok</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'gapok') }}" name="gapok" id="gapok" value="{{ old('gapok') }}">
                {!! show_inline_error($errors, 'gapok') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="uang_makan">Uang Makan</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'uang_makan') }}" name="uang_makan" id="uang_makan" value="{{ old('uang_makan') }}">
                {!! show_inline_error($errors, 'uang_makan') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="col-md">
                <div class="form-group">
                  <label for="sa_harian">SA Harian</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'sa_harian') }}" name="sa_harian" id="sa_harian" value="{{ old('sa_harian') }}">
                  {!! show_inline_error($errors, 'sa_harian') !!}
                </div>
              </div>
            </div>
            <div class="col-md">
              <div class="form-group ">
                <label for="tunjangan">Tunjangan</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'tunjangan') }}" name="tunjangan" id="tunjangan" value="{{ old('tunjangan') }}">
                {!! show_inline_error($errors, 'tunjangan') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group ">
                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'tanggal_masuk') }}" name="tanggal_masuk" id="tanggal_masuk" data-toggle="datepicker" value="{{ old('tanggal_masuk') }}">
                {!! show_inline_error($errors, 'tanggal_masuk') !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'tanggal_keluar') }}" name="tanggal_keluar" id="tanggal_keluar" data-toggle="datepicker" value="{{ old('tanggal_keluar') }}">
                {!! show_inline_error($errors, 'tanggal_keluar') !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group ">
                <label for="status_kerja">Status Kerja</label>
                <select name="status_kerja" id="status_kerja" class="form-control {{is_invalid($errors,'status_kerja')}}">
                  <option value="">Pilih Status Kerja</option>
                  <option value="Tetap" {{ old('status_kerja') == 'Tetap'?'selected':''}}>Tetap</option>
                  <option value="Kontrak" {{ old('status_kerja') == 'Kontrak'?'selected':''}}>Kontrak</option>
                  <option value="Harian" {{ old('status_kerja') == 'Harian'?'selected':''}}>Harian</option>
                </select>
                {!! show_inline_error($errors, 'tanggal_masuk') !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="jenis_kerja">Jenis Kerja</label>
                <select name="jenis_kerja" id="jenis_kerja" class="form-control {{is_invalid($errors,'jenis_kerja')}}">
                  <option value="">Pilih Jenis Kerja</option>
                  <option value="NPWK" {{old('jenis_kerja') == 'NPWK'?'selected':''}}>NPWK</option>
                  <option value="PTWK" {{old('jenis_kerja') == 'PTWK'?'selected':''}}>PTWK</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group ">
                <label for="kode">Kode</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'kode') }}" name="kode" id="kode" value="{{ old('kode') }}">
                {!! show_inline_error($errors, 'kode') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="nrp">NRP</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'nrp') }}" name="nrp" id="nrp" value="{{ old('nrp') }}">
                {!! show_inline_error($errors, 'nrp') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'nik') }}" name="nik" id="nik" value="{{ old('nik') }}">
                {!! show_inline_error($errors, 'nik') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="npwp">Nomor NPWP</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'npwp') }}" name="npwp" id="npwp" value="{{ old('npwp') == 0?'':old('npwp')}}">
                {!! show_inline_error($errors, 'npwp') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="jamsostek">Nomor JAMSOSTEK</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'jamsostek') }}" name="jamsostek" id="jamsostek" value="{{ old('jamsostek') == 0?'':old('jamsostek') }}">
                {!! show_inline_error($errors, 'jamsostek') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="rekening">Nomor Rekening</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'rekening') }}" name="rekening" id="rekening" value="{{ old('rekening') == 0?'':old('rekening') }}">
                {!! show_inline_error($errors, 'rekening') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="bpjs">Nomor BPJS</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'bpjs') }}" name="bpjs" id="bpjs" value="{{ old('bpjs') == 0?'':old('bpjs') }}">
                {!! show_inline_error($errors, 'bpjs') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="bpjs_tk">Biaya BPJS Tenaga Kerja</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'bpjs_tk') }}" name="bpjs_tk" id="bpjs_tk" value="{{ old('bpjs_tk') == 0?'':old('bpjs_tk') }}">
                {!! show_inline_error($errors, 'bpjs_tk') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="bpjs_kes">Biaya BPJS Kesehatan</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'bpjs_kes') }}" name="bpjs_kes" id="bpjs_kes" value="{{ old('bpjs_kes') == 0?'':old('bpjs_kes') }}">
                {!! show_inline_error($errors, 'bpjs_kes') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="jenis_bank">Jenis Bank</label>
                <select class="form-control {{ is_invalid($errors, 'jenis_bank') }}" id="jenis_bank" name="jenis_bank">
                  <option value="">Pilih Bank</option>
                  <option value="BNI" {{ old('jenis_bank') == 'BNI'?'selected':''}}>BNI</option>
                  <option value="BRI" {{ old('jenis_bank') == 'BRI'?'selected':''}}>BRI</option>
                  <option value="BCA" {{ old('jenis_bank') == 'BCA'?'selected':''}}>BCA</option>
                  <option value="Mandiri" {{ old('jenis_bank') == 'Mandiri'?'selected':''}}>Mandiri</option>
                </select>
                {!! show_inline_error($errors, 'jenis_bank') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="cabang_bank">Cabang Bank</label>
                <input type="text" class="form-control {{is_invalid($errors, 'cabang_bank')}}" name="cabang_bank" id="cabang_bank" value="{{old('cabang_bank')}}">
                {!! show_inline_error($errors, 'cabang_bank') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="cara_bayar">Cara Bayar</label>
                <select name="cara_bayar" id="cara_bayar" class="form-control {{ is_invalid($errors, 'cara_bayar')}}">
                  <option value="">Pilih Cara Bayar</option>
                  <option value="Transfer" {{ old('cara_bayar') == 'Transfer'?'selected':''}}>Transfer</option>
                  <option value="Cash" {{ old('cara_bayar') == 'Cash'?'selected':''}}>Cash</option>
                </select>
                {!! show_inline_error($errors, 'cara_bayar') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="status_pernikahan">Status Pernikahan</label>
                <select class="form-control {{ is_invalid($errors, 'status_pernikahan') }}" name="status_pernikahan" id="status_pernikahan" style="height:35px">
                  <option value="">Pilih Status</option>
                  <option value="Lajang" {{ old('status_pernikahan') == 'Lajang'?'selected':''}}>Lajang</option>
                  <option value="Menikah" {{ old('status_pernikahan') == 'Menikah'?'selected':''}}>Menikah</option>
                  <option value="Duda" {{ old('status_pernikahan') == 'Duda'?'selected':''}}>Duda</option>
                  <option value="Janda" {{ old('status_pernikahan') == 'Janda'?'selected':''}}>Janda</option>
                </select>
                {!! show_inline_error($errors, 'status_pernikahan') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="fiskal">Fiskal</label>
                <select name="fiskal" id="fiskal" class="form-control {{ is_invalid($errors, 'fiskal')}}">
                  <option value="">Pilih Fiskal</option>
                  <option value="S/0" {{old('fiskal') == 'S/0'?'selected':''}}>S/0</option>
                  <option value="K/0" {{old('fiskal') == 'K/0'?'selected':''}}>K/0</option>
                  <option value="K/1" {{old('fiskal') == 'K/1'?'selected':''}}>K/1</option>
                  <option value="K/2" {{old('fiskal') == 'K/2'?'selected':''}}>K/2</option>
                  <option value="K/3" {{old('fiskal') == 'K/3'?'selected':''}}>K/3</option>
                </select>
                {!! show_inline_error($errors, 'fiskal') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <label for="pengaturan_id">Pengaturan Rumus</label>
              <select name="pengaturan_id" id="pengaturan_id" class="form-control {{is_invalid($errors,'pengaturan_id')}}" style="height:35px">
                <option value="">Pilih Pengaturan Rumus</option>
                @foreach ($pengaturan as $index => $item)
                  <option value="{{$item->id}}" {{old('pengaturan_id') == $item->id?'selected':''}}>Hauling Trip = {{'Rp.'.number_format($item->biasa)}},{{'Rp.'.number_format($item->lumayan)}},{{'Rp.'.number_format($item->bonus)}} Dan
                                                Hour Meter = {{'Rp.'.number_format($item->alat_biasa)}},{{'Rp.'.number_format($item->alat_spesial)}} </option>
                @endforeach
              </select>
              {!! show_inline_error($errors,'pengaturan_id') !!}
            </div>
            <div class="col-md">
              <label for="setabsen_id">Pengaturan Nominal Absen</label>
              <select name="setabsen_id" id="setabsen_id" class="form-control {{is_invalid($errors,'setabsen_id')}}" style="height:35px">
                <option value="">Pilih Pengaturan Nominal Absen</option>
                @foreach ($setAbsen as $index => $item)
                  <option value="{{$item->id}}" {{old('setabsen_id') == $item->id?'selected':''}}>Alpha = {{'Rp.'.number_format($item->a)}}</option>
                @endforeach
              </select>
              {!! show_inline_error($errors,'setabsen_id')!!}
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="sim_a">SIM A</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'sim_a') }}" name="sim_a" id="sim_a" value="{{ old('sim_a') }}">
                {!! show_inline_error($errors, 'sim_a') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="sim_b">SIM B</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'sim_b') }}" name="sim_b" id="sim_b" value="{{ old('sim_b') }}">
                {!! show_inline_error($errors, 'sim_b') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="sim_b2">SIM B2</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'sim_b2') }}" name="sim_b2" id="sim_b2" value="{{ old('sim_b2') }}">
                {!! show_inline_error($errors, 'sim_b2') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="sim_c">SIM C</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'sim_c') }}" name="sim_c" id="sim_c" value="{{ old('sim_c') }}">
                {!! show_inline_error($errors, 'sim_c') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="simper">SIM Per</label>
                  <input type="text" class="form-control {{ is_invalid($errors, 'simper') }}" name="simper" id="simper" value="{{ old('simper') }}">
                {!! show_inline_error($errors, 'simper') !!}
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="foto">Foto</label><br>
            <img src="{{ old('foto_url', 'http://placehold.it/500x500?text=foto+profile') }}" width="200">
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
    @include('master.karyawan.table');
  </div>
@endsection
