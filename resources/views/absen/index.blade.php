@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3>Absen</h3>
      </div>
        <div class="col-md-7 text-right">
          <form method="get" id="absen_form" action ="{{route('absen.index')}}">
            <div class="row">
              <label for="nama" class="col-md-1 col-form-label" style="font-size: 20px">Nama </label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="nama" id="nama" value="{{request('nama')}}">
              </div>
              <label for="bulan" class="col-md-1 col-form-label" style="font-size: 20px">Bulan </label>
              <div class="col-md-3">
                <select class="form-control  custom-select" id="bulan" name="bulan">
                  @foreach($listBulan as $index => $bulan)
                    <option value="{{ $index + 1 }}" {{ (request('bulan', date('n'))-1) ==  $index ? 'selected' : '' }}>{{ $bulan }}</option>
                  @endforeach
                </select>
              </div>
              <label for="tahun" class="col-md-1 col-form-label" style="font-size: 20px">Tahun </label>
              <div class="col-md-2">
                <select class="form-control  custom-select" id="tahun" name="tahun">
                  @for ($tahun = $tahunSekarang->copy(); $tahun->diffInYears($tahunAwal) ; $tahun->subYear())
                    <option value="{{$tahun->format('Y')}}" {{request('tahun')==$tahun->format('Y')?'selected':''}}>{{$tahun->format('Y')}}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter fa-fw"></i> Filter</button>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-responsive legend-absen">
          <thead>
            <tr class="table-primary">
              <th colspan = '12'>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($keteranganAbsen as $index => $item)
              @if ($index == 'pindah' || $index == 'pindah2')
                <tr></tr>
              @else
            <td><span class="{{ $index }}">{{ $index }}</span></td>
                <td>=</td>
                <td>{{$item}}</td>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <hr class="dashed mt20 mb20">

    @if (Auth::user()->username == 'admin')
      <div class="col-md-12 text-right">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-2">
            <div class="form-group">
              <button type="submit" name="laporan" value="laporan" class="btn btn-warning btn-block btn-md rekap"><i class="fa fa-bar-chart"></i> Laporan Transaksi</button>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <button type="submit" name="rekap" value="rekap" class="btn btn-primary btn-block btn-md rekap"><i class="fa fa-file-code-o"></i> Rekap</button>
            </div>
          </div>
          </form>
          <div class="col-md-2">
            <div class="form-group">
              <label for="excel"></label>
              <input type="file" id="excel" class="file {{is_invalid($errors,'excel')}}" style="padding-bottom:10px" name="excel">
              {!! show_inline_error($errors,'excel') !!}
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <button type="submit" name="import" value="import" class="btn btn-success btn-block btn-md rekap"><i class="fa fa-file"></i> Import</button>
            </div>
          </div>
        </div>
      </div>

    @endif

    <div class="col-md-12" style="overflow:scroll;max-width:100%;">
      <form action="{{route('absen.update')}}" method="post" class="form-horizontal">
        <input type="hidden" name="_method" value="{{ $method }}">
        {{ csrf_field() }}
      <div class="table-wrapper">
        <table class="table table-custom table-bordered table-sm table-absen">
          <thead>
            <tr class="table-primary">
              <th rowspan="3" class="text-center mar">No.</th>
              <th rowspan="3" class="text-center mar">NIK</th>
              <th rowspan="3" class="text-center mar">Nama Karyawan</th>
              <th colspan="{{ $mulai->copy()->endOfMonth()->format('j') }}" class="text-center">
                Bulan {{ trans('date.month.key.full.' . $mulai->format('n')) }} Tanggal
              </th>
              <th nowrap rowspan="3" class="text-center mar">Rumus</th>
              <th nowrap rowspan="3" class="text-center mar">Nominal Absen</th>
            </tr>
            <tr class="table-primary">
              @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                <th class="text-center">{{ $date->format('d') }}</th>
              @endfor
            </tr>
            <tr class="table-primary">
              @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                {{-- {{trans('date.day.' . $date->format('l')) == 'Minggu'?'style=background:#00B0F0':''}} --}}
                <th  {{trans('date.day.' . $date->format('l')) == 'Minggu'?'style=background:#FF0000;':''}}>{{ trans('date.day.' . $date->format('l')) }}</th>
              @endfor
            </tr>
          </thead>
          <tbody>
            @forelse ($karyawan as $index => $item)
              @if ($item->biodata)
                @php
                    if ($karyawan->currentPage() >= 1) {
                        $no = (($karyawan->currentPage() * 10) - 10) + $index + 1 ;
                    }
                @endphp
                <tr>
                  <td align="center">{{ $no }}</td>
                  <td align="center">{{ $item->nik }}</td>
                  <td nowrap>{{ $item->biodata->nama_lengkap }}</td>
                  @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                    <td class="has-select {{ array_get($listAbsen[$date->format('Y-m-d')], $item->id) }}">
                      <select name="status[{{ $date->format('Y-m-d') }}][{{ $item->id }}]" align="center" class="select-absen">
                        @foreach($kodeAbsen as $kode)
                        <option value="{{ $kode }}" {{ array_get($listAbsen[$date->format('Y-m-d')], $item->id) == $kode ? 'selected' : '' }}>{{ $kode }}</option>
                        @endforeach
                      </select>
                    </td>
                  @endfor
                  <td nowrap>{{$listPengaturan[$item->id]}}</td>
                  <td nowrap>{{$listAlpa[$item->id]}}</td>
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="{{ $selesai->format('d') + 3 }}" align="center">Tidak ada data</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <br>
      <div class="row">
        <div class="col-md-10 ">
          {!! $karyawan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Update</button>
        </div>
      </div>
      <br>
      </form>
  </div>
@endsection
