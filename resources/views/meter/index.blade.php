@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3>
          HM Alat
        </h3>
      </div>
      <div class="col-md-7 text-right">
        <form action="{{route('meter.index')}}" method="get">
          <div class="row">
            <div class="col-md-2"></div>
            <label for="bulan" class="col-md-1 col-form-label" style="font-size: 20px">Bulan </label>
            <div class="col-md-3">
              <select class="form-control  custom-select" id="bulan" name="bulan">
                @foreach($listBulan as $index => $bulan)
                  <option value="{{ $index + 1 }}" {{ (request('bulan', date('n'))-1) ==  $index ? 'selected' : '' }}>{{ $bulan }}</option>
                @endforeach
              </select>
            </div>
            <label for="tahun" class="col-md-1 col-form-label" style="font-size: 20px">Tahun</label>
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
    <hr class="dashed mt20 mb20">
    <div class="col-md-12 text-right">
      <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <div class="form-group">
            <button type="submit" name="rekap" value="rekap" class="btn btn-success btn-block btn-md rekap"><i class="fa fa-file-code-o"></i> Rekap</button>
          </div>
        </div>
      </div>
    </div>
    </form>
    <div class="col-md-12" style="overflow:scroll;max-width:100%;">
      <div class="table-wrapper">
        <table class="table table-custom table-bordered table-sm table-absen">
          <thead>
            <tr class="table-primary">
              <th rowspan="3" class="text-center mar">No</th>
              <th nowrap rowspan="3" class="text-center mar">Nama Karyawan</th>
              <th colspan="{{ $mulai->copy()->endOfMonth()->format('j') }}" class="text-center">
                Bulan {{ trans('date.month.key.full.' . $mulai->format('n')) }} Tanggal
              </th>
              <th rowspan="3" class="text-center mar">Total</th>
              <tr class="table-primary">
                @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                  <th class="text-center">{{ $date->format('d') }}</th>
                @endfor
              </tr>
              <tr class="table-primary">
                @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                  <th class="text-center">{{ trans('date.day.' . $date->format('l')) }}</th>
                @endfor
              </tr>
            </tr>
          </thead>
          <tbody>
            @forelse ($karyawan as $index => $item)
              @if ($item->karyawan->biodata)
                @php
                  if ($karyawan->currentPage() >= 1) {
                      $nomor = (($karyawan->currentPage() * 10)-10) +$index + 1 ;
                      $total_harga=number_format(array_get($totalHarga,$item->karyawan->id),2,",",".");
                  }
                @endphp
                <tr align="center">
                  <td rowspan="2" style="padding-top:16px">{{$nomor}}</td>
                  <td rowspan="2" style="padding-top:16px" nowrap>{{$item->karyawan->biodata->nama_lengkap}}</td>
                  {{-- $date->format('Y-m-d') --}}
                    @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                      <td nowrap>{{array_get($jam[$date->format('Y-m-d')],$item->karyawan->id)}}</td>
                    @endfor
                  <td rowspan="2" nowrap style="padding-top:16px">{{$totalHargaa[$item->karyawan_id] == 0?'':'Rp. '.number_format($totalHargaa[$item->karyawan_id],2,",",".")}}</td>
                </tr>
                <tr>
                  @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                    @php
                      $angka_meter = number_format(array_get($meter[$date->format('Y-m-d')],$item->karyawan_id),2,",",".");
                    @endphp
                    <td nowrap>{{$angka_meter == 0?'':'Rp. '.$angka_meter}}</td>
                  @endfor
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="{{$selesai->format('d') + 3}}" align="center">Tidak ada data</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        {!! $karyawan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
      </div>
    </div>
@endsection
