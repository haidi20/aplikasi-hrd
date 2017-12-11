@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Master Keluarga
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('master::keluarga.index',['biodata_id'=>request('biodata_id')]) }}" class="btn btn-primary btn-sm">
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
          <input type="hidden" value="{{$biodata_id}}" name="biodata_id">
          <div class="form-group">
            <label for="jenis">Hubungan Keluarga</label>
            <select name="hubungan_keluarga" id="jenis" class="form-control {{is_invalid($errors, 'hubungan_keluarga')}}" style="height:45px">
              <option value="">Pilih Hubungan Keluarga</option>
              <option value="Ayah" {{ old('jenis') == 'Ayah'?'selected':'' }}>Ayah</option>
              <option value="Ibu" {{ old('jenis') == 'Ibu'?'selected':'' }}>Ibu</option>
              <option value="Anak" {{ old('jenis') == 'Anak'?'selected':'' }}>Anak</option>
            </select>
            {!! show_inline_error($errors, 'hubungan_keluarga') !!}
          </div>
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control {{is_invalid($errors,'nama')}}" value="{{old('nama')}}">
            {!! show_inline_error($errors, 'nama') !!}
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="text" name="tanggal_lahir" id="tanggal_lahir" data-toggle="datepicker" class="form-control {{is_invalid($errors,'tanggal_lahir')}}" value="{{old('tanggal_lahir')}}">
                {!! show_inline_error($errors, 'tanggal_lahir') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control {{is_invalid($errors, 'jenis_kelamin')}}">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="Laki-laki" {{old('jenis_kelamin') == 'Laki-laki'?'selected':''}}>Laki-laki</option>
                  <option value="Perempuan" {{old('jenis_kelamin') == 'Perempuan'?'selected':''}}>Perempuan</option>
                </select>
                {!! show_inline_error($errors, 'jenis_kelamin') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="pendidikan">Pendidikan Terkahir</label>
                <select class="form-control custom-select {{ is_invalid($errors, 'pendidikan') }}" id="pendidikan" name="pendidikan">
                  <option value="">Pilih Pendidikan</option>
                  @foreach ($listPendidikan as $pendidikan)
                    <option value="{{$pendidikan}}" {{ old('pendidikan_terakhir') == $pendidikan ? 'selected' : '' }}>{{$pendidikan}}</option>
                  @endforeach
                </select>
                {!! show_inline_error($errors, 'pendidikan') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control {{is_invalid($errors,'pekerjaan')}}" value="{{old('pekerjaan')}}">
                {!! show_inline_error($errors, 'pekerjaan') !!}
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
    @include('master.keluarga.table')
  </div>
@endsection
