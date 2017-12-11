@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3>
          Trip
        </h3>
      </div>
      <div class="col-md-7 text-right">
        <form action="{{route('trip.index')}}" method="get">
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
        {{-- @if (Auth::user()->username == 'admin') --}}
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
              <th rowspan="3" class="text-center mar" >No</th>
              <th rowspan="3" class="text-center mar">Nama Karyawan</th>
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
              @if ($item->karyawan->biodata && $item->karyawan)
                @php
                  if ($karyawan->currentPage() >= 1) {
                      $nomor = (($karyawan->currentPage() * 10)-10) +$index + 1 ;
                  }
                  $numTotalNominalTrip = number_format($totalNominalTrip[$item->karyawan->id],2);
                @endphp
                <tr>
                  <td align="center">{{$nomor}}</td>
                  <td nowrap>{{$item->karyawan->biodata->nama_lengkap}}</td>
                  @for ($date = $mulai->copy(); $date->diffInDays($akhir) ; $date->addDay())
                    @php
                      $numNominalTrip = number_format(array_get($nominalTrip[$date->format('Y-m-d')],$item->karyawan->id),2);
                    @endphp
                    <td nowrap> {{$numNominalTrip == 0?'':'Rp. '.$numNominalTrip}}</td>
                  @endfor
                  <td nowrap>{{$numTotalNominalTrip == 0?'':'Rp. '.$numTotalNominalTrip}}</td>
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
