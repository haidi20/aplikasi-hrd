@extends('_layout.default')

@section('content')
  <div class="container">
    <div id="header">
      <div class="row">
        <div class="col-md-2 noprint">
          <h3>
            Slip
          </h3>
        </div>
        <div class="col-md-10 text-right">
          <form action="{{route('slip.index')}}" method="get">
            <div class="row">
              <div class="col-md-3 noprint"></div>
              <div class="col-md-3 col-sm-5 col-xs-3 noprint">
                <label for="karyawan" class="col-form-label">Karyawan </label>
                <select class="form-control select2" id="karyawan" name="karyawan">
                  @foreach ($karyawanAll as $index => $item)
                    @if ($item->biodata)
                      <option value="{{$item->id}}" {{$idKaryawan == $item->id?'selected':''}}>{{$item->biodata->nama_lengkap}}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="col-md-2 noprint">
                <label for="bulan" class="col-form-label">Bulan </label>
                <select class="form-control  custom-select" id="bulan" name="bulan">
                  @foreach($listBulan as $index => $bulan)
                    <option value="{{ $index + 1 }}" {{ (request('bulan', date('n'))-1) ==  $index ? 'selected' : '' }}>{{ $bulan }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 noprint">
                <label for="tahun" class="col-form-label">Tahun </label>
                <select class="form-control  custom-select" id="tahun" name="tahun">
                  @for ($tahun = $tahunSekarang->copy(); $tahun->diffInYears($tahunAwal) ; $tahun->subYear())
                    <option value="{{$tahun->format('Y')}}" {{request('tahun')==$tahun->format('Y')?'selected':''}}>{{$tahun->format('Y')}}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-2 noprint">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block noprint" style="margin-top:26px;margin-bottom:0px"><i class="fa fa-filter fa-fw"></i> Filter</button>
                </div>
              </div>
            </div>
        </div>
      </div>

    <hr class="dashed mt20 mb20 noprint">
    <div class="col-md-12 text-right noprint">
      <div class="row">
        <div class="col-md-6 col- noprint"></div>
        <div class="col-md-2 col- noprint">
          <div class="form-group">
            <button type="submit" name="rekap" value="rekap" class="btn btn-primary btn-block btn-md rekap noprint"><i class="fa fa-file-code-o"></i> Rekap</button>
          </div>
        </div>
        <div class="col-md-2 col- noprint">
          <button type="button" name="print" value="print" class="btn btn-success btn-block btn-md noprint" id="print" media="print" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        </div>
        </form>
        <div class="col-md-2 col- noprint">
          <a href="?hide-pph21={{ $hidePPH21 ? 'false': 'true'}}" class="btn btn-danger btn-block btn-md noprint">{{ $hidePPH21?'Munculkan':'Hilangkan'}} PPH21</a>
        </div>
      </div>
    </div>
    </div>
      <div class="col-md-12 col-">
        @include('slip.kotak_atas')
      </div>
      <div class="col-md-12 col-xs-12 noprint">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <div class="table-wrapper">
              <table class="table table-custom table-bordered table-stripped table-sm table-absen">
                <thead>
                  <tr class="table-primary" align="center">
                    <th rowspan = "2">No</th>
                    <th rowspan = "2">Tanggal</th>
                    <th rowspan = "2">Hari</th>
                    <th rowspan = "2">Status</th>
                    <th colspan = "2">HM</th>
                    <th colspan = "2">TRIP</th>
                  </tr>
                  <tr class="table-primary" align="center">
                    <th>Total</th>
                    <th>Insentif</th>
                    <th>Total</th>
                    <th>Insentif</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no = 1 ;
                  @endphp
                  @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                    @php
                      $kon_listNominalHM   = number_format(array_get($listNominalHM,$date->format('Y-m-d')),2,",",".");
                      $kon_listNominalTrip = number_format(array_get($listNominalTrip,$date->format('Y-m-d')),2,",",".");
                    @endphp
                    <tr>
                      <td>{{$no++}}</td>
                      <td>{{$date->format('Y-m-d')}}</td>
                      <td>{{trans('date.day.' . $date->format('l')) }}</td>
                      <td>{{array_get($listAbsen,$date->format('Y-m-d'))}}</td>
                      <td>{{array_get($listHM,$date->format('Y-m-d'))}}</td>
                      <td>{{$kon_listNominalHM == 0?'':$kon_listNominalHM}}</td>
                      <td>{{array_get($listTrip,$date->format('Y-m-d'))}}</td>
                      <td>{{$kon_listNominalTrip == 0?'':$kon_listNominalTrip}}</td>
                    </tr>
                  @endfor
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-4 col-">
            @include('slip.kotak_kanan')
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm2 noprint">
        <div class="row">
          <div class="col-md-6 col-sm">
            @include('slip.kotak_bawah')
          </div>
          <div class="col-md-6 col-sm">
            <div style="height:220px"></div>
            <table border="1" style="text-align:center;height:45%" class="table table-custom table-bordered table-sm table-absen">
              <thead>
                <tr>
                  <th>Karyawan</th>
                  <th>HRD</th>
                  <th>Finance</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center;padding-top:135px"> {{$karyawan->biodata->nama_lengkap}}</td>
                  <td ><img src="{{ $karyawan->foto_url }}" width="150"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="noprint">
        <br><br><br><br>
      </div>

      <div class="print">
        @include('slip.print')
      </div>
@endsection
