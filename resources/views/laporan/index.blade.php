@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Laporan Kalkulasi
        </h3>
      </div>
        <div class="col-md-6 text-right">
          {{-- <a href="{{ route('master::jabatan.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Tambah</a> --}}
        </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="col-md-12" style="overflow:scroll;max-width:100%;">
      <table class="table table-bordered table-custom table-hover table-striped table-sm">
        <thead>
          <tr>
            <th nowrap rowspan="2" class="text-center">No</th>
            <th nowrap rowspan="2" class="text-center">Nama</th>
            <th nowrap rowspan="2" class="text-center">Departemen</th>
            <th nowrap colspan="2" class="text-center">Jam Kerja</th>
            <th nowrap colspan="2" class="text-center">Terlambat</th>
            <th nowrap colspan="2" class="text-center">Pulang Cepat</th>
            <th nowrap colspan="2" class="text-center">Lembur (Hr = Hari)</th>
            <th nowrap rowspan="2" class="text-center">Kehadiran (Nor./Real)</th>
            <th nowrap rowspan="2" class="text-center">D.luar (Hari)</th>
            <th nowrap rowspan="2" class="text-center">Bolos</th>
            <th nowrap rowspan="2" class="text-center">Izin</th>
            <th nowrap colspan="5" class="text-center">Komponen Penambahan Gaji</th>
            <th nowrap colspan="3" class="text-center">Komponen Pengurangan Gaji</th>
            <th nowrap rowspan="2" class="text-center">Total Gaji</th>
            <th nowrap rowspan="2" class="text-center">Catatan</th>
          </tr>
          <tr>
            <th nowrap>Normal</th>
            <th nowrap>Real</th>
            <th nowrap>Kali</th>
            <th nowrap>Menit</th>
            <th nowrap>Hr Normal</th>
            <th nowrap>Hr Libur</th>
            <th nowrap>Harian</th>
            <th nowrap>Trans</th>
            <th nowrap>Tunj.</th>
            <th nowrap>L. Nor.</th>
            <th nowrap>L. Lib.</th>
            <th nowrap>TL</th>
            <th nowrap>PC</th>
            <th nowrap>Hut.</th>
            <th nowrap>Jams. </th>
            <th nowrap>PPh</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($karyawan as $index => $item)
            @if ($item->biodata && $item->jabatan)
              <tr>
                <td nowrap>{{$index+1}}</td>
                <td nowrap>{{$item->biodata->nama_lengkap}}</td>
                <td nowrap>{{$item->jabatan->nama}}</td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
                <td nowrap></td>
              </tr>
            @endif
          @empty
            <td colspan="10">Tidak Ada Data</td>
          @endforelse
        </tbody>
      </table>
    </div>
    {!! $karyawan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
  </div>
@endsection
