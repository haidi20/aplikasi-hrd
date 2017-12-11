@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Dashboard
        </h3>
      </div>
      <div class="col-md-6 text-right">
        {{-- <a href="{{ route('master::departemen.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Tambah</a> --}}
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    {!! $finger !!}
    <br>
    <div class="row">
      <div class="col-md-12">
        <h4>Notifikasi Masa Berlaku KTP</h4>
      </div>
    </div>
    <table class="table table-bordered table-custom table-hover table-striped table-sm">
      <thead>
        <tr>
          <th width="30px">No</th>
          <th>NIK</th>
          <th>Nama Lengkap</th>
          <th width="300px">Tanggal Akhir KTP</th>
          <th>Jangka Waktu</th>
        </tr>
      </thead>
      <tbody>
        @forelse($ktp as $index => $item)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->nik}}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->akhir_ktp }}</td>
            <td>{{ $masaBerlakuKtp[$item->id] == 0?'Sekarang':'H'.$statusKtp[$item->id].$masaBerlakuKtp[$item->id] }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" align="center">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-12">
        <h4>Notifikasi Sisa Masa Kontrak Kerja</h4>
      </div>
    </div>
    <table class="table table-bordered table-custom table-hover table-striped table-sm">
      <thead>
        <tr>
          <th width="30px">No</th>
          <th>NIK</th>
          <th>Nama Lengkap</th>
          <th width="300px">Tanggal Akhir Kontrak Kerja</th>
          <th>Jangka Waktu</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kontrak as $index => $item)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->nik}}</td>
            <td>{{ $item->biodata->nama_lengkap }}</td>
            <td>{{ $item->tanggal_keluar }}</td>
            <td>{{ $masaBerlakuKontrak[$item->id] == 0?'Sekarang':'H'.$statusKontrak[$item->id].$masaBerlakuKontrak[$item->id] }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" align="center">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-12">
        <h4>Notifikasi Kasbon</h4>
      </div>
    </div>
    <table class="table table-bordered table-custom table-hover table-striped table-sm">
      <thead>
        <tr>
          <th width="30px">No</th>
          <th>NIK</th>
          <th>Nama Lengkap</th>
          <th>Kategori</th>
          <th>Nominal</th>
          <th width="300px">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($potongan as $index => $item)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->karyawan->nik}}</td>
            <td>{{ $item->karyawan->biodata->nama_lengkap }}</td>
            <td>{{ $item->kategori}}</td>
            <td>Rp. {{ number_format($item->nominal,2)}}</td>
            <td>{{ $item->tanggal }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" align="center">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-12">
        <h4>Notifikasi Rapel</h4>
      </div>
    </div>
    <table class="table table-bordered table-custom table-hover table-striped table-sm">
      <thead>
        <tr>
          <th width="30px">No</th>
          <th>NIK</th>
          <th>Nama Lengkap</th>
          <th>Kategori</th>
          <th>Nominal</th>
          <th width="300px">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tambahan as $index => $item)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->karyawan->nik}}</td>
            <td>{{ $item->karyawan->biodata->nama_lengkap }}</td>
            <td>{{ $item->kategori}}</td>
            <td>Rp. {{ number_format($item->nominal,2)}}</td>
            <td>{{ $item->tanggal }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" align="center">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- {!! $ktp->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!} --}}
  </div>
@endsection
