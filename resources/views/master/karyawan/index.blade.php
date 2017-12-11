@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Master Karyawan
        </h3>
      </div>
      <div class="col-md-6 text-right">
        @if (Auth::user()->username == 'admin')
          <a href="{{ route('master::karyawan.create')}}" class="btn btn-primary btn-md"><i class="fa fa-plus-circle"></i> Tambah</a>
        @endif
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <form action="{{route('master::karyawan.index')}}" method="get">
    <div class="row">
      {{-- <div class="col-md-2"></div> --}}
      <div class="col-md-2">
        <label for="jabatan" class="form-label text-right" style="font-size: 20px">Jabatan </label>
        <select class="form-control  custom-select select2" id="jabatan" name="jabatan">
          <option value="">Semua Jabatan</option>
          @foreach ($jabatan as $index => $item)
            <option value="{{$item->id}}" {{$item->id == request('jabatan')?'selected':''}}>{{$item->nama}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="departemen" class="form-label text-right" style="font-size: 20px">Departemen </label>
        <select class="form-control  custom-select select2" id="departemen" name="departemen">
          <option value="">Semua Departemen</option>
          @foreach ($departemen as $index => $item)
            <option value="{{$item->id}}" {{$item->id == request('departemen')?'selected':''}}>{{$item->nama}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="nikFind" class="form-label text-right" style="font-size: 20px">NIK </label>
        <select class="form-control  custom-select select2" id="nikFind" name="nikFind">
          <option value="">Semua NIK</option>
          @foreach ($karyawanAll as $index => $item)
            @if (!empty($item->nik))
              <option value="{{$item->nik}}" {{$item->nik == request('nikFind')?'selected':''}}>{{$item->nik}}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="namaFind" class="form-label text-right" style="font-size: 20px">Nama Karyawan </label>
        <select class="form-control  custom-select select2" id="namaFind" name="namaFind">
          <option value="">Semua Nama Karyawan</option>
          @foreach ($karyawanAll as $index => $item)
            @if ($item->biodata)
              <option value="{{$item->biodata_id}}" {{$item->biodata_id == request('namaFind')?'selected':''}}>{{$item->biodata->nama_lengkap}}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="site" class="form-label text-right" style="font-size: 20px">Site </label>
        <select class="form-control  custom-select select2" id="site" name="site">
          <option value="">Semua Site</option>
          @foreach($site as $index => $item)
            <option value="{{ $item->id }}" {{request('site') == $item->id? 'selected':''}}>{{ $item->lokasi }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2" style="padding-top:35px">
        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-filter fa-fw"></i> Filter</button>
      </div>
    </div>
    </form>
    <br>
    @include('master.karyawan.table')
  </div>
@endsection
