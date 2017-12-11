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
        <a href="{{ route('absen.index') }}" class="btn btn-primary btn-xs">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <form action="{{ $action }}" method="post" class="form-horizontal">
          <input type="hidden" name="_method" value="{{$method}}">
          {{ csrf_field() }}
          <div class="form-group {{ has_error($errors, 'karyawan_id') }}">
            <label for="karyawan_id" class="control-label col-md-3">Nama</label>
            <div class="col-md-9">
              <select class="form-control" id="karyawan_id" name="karyawan_id">
                <option value="">Pilih Nama</option>
                @foreach ($biodata as $item)
                  <option value="{{$item->id}}" {{ old('karyawan_id') == $item->id ? 'selected' : '' }}>{{$item->nama_lengkap}}</option>
                @endforeach
              </select>
              {!! show_inline_error($errors, 'karyawan_id') !!}
            </div>
          </div>
          <div class="form-group {{ has_error($errors, 'tanggal') }}">
            <label for="tanggal" class="control-label col-md-3">Tanggal</label>
            <div class="col-md-9">
              <input type="text" class="form-control" name="tanggal" id="tanggal" data-toggle="datepicker" value="{{ old('tanggal') }}">
              {!! show_inline_error($errors, 'tanggal') !!}
            </div>
          </div>
          <div class="form-group {{ has_error($errors, 'status') }}">
            <label for="status" class="control-label col-md-3">Status</label>
            <div class="col-md-9">
              <select class="form-control" id="status" name="status">
                <option value="">Pilih Status</option>
                <option value="H">Hadir</option>
                <option value="IR">Ijin Resmi</option>
                <option value="I">Ijin Tidak Resmi</option>
                <option value="S">Sakit Surat Dokter</option>
                <option value="S1">Sakit Tanpa Surat</option>
                <option value="A">Alpha</option>
                <option value="Mi">Setengah Hari</option>
                <option value="CT">Cuti</option>
                <option value="L">Libur Nasional</option>
                <option value="M">Minggu</option>
                <option value="OFF">OFF</option>
                <option value="X">New/Resign</option>
              </select>
              {!! show_inline_error($errors, 'status') !!}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-save fa-fw"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
