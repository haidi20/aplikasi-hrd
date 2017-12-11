<html>
  <td>
    <tr>
      <td>Nama</td>
      <td></td>
      <td align="center">:</td>
      <td>{{$karyawan->biodata->nama_lengkap}}</td>
    </tr>
    <tr>
      <td>NIK</td>
      <td></td>
      <td align="center">:</td>
      <td>{{$karyawan->nik}}</td>
    </tr>
    <tr>
      <td>Posisi/Jabatan</td>
      <td></td>
      <td align="center">:</td>
      <td>{{$karyawan->jabatan->nama}}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>DOH</td>
      <td align="center">:</td>
      <td>{{$sekarang->format('d-M-Y')}}</td>
    </tr>
    <tr>
      <td>Departemen</td>
      <td></td>
      <td align="center">:</td>
      <td>{{$karyawan->departemen->nama}}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>NPWP</td>
      <td align="center">:</td>
      <td align="left">{{$karyawan->npwp}}</td>
    </tr>
    <tr>
      <td>kiri</td>
    </tr>
  </td>
  <td>
    <tr class="table-primary">
      <td align="center">No</td>
      <td align="center">Tanggal</td>
      <td align="center">Hari</td>
      <td align="center">Status</td>
      <td align="center">HM</td>
      <td align="center">TRIP</td>
    </tr>
    <tr class="table-primary">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td align="center">Total</td>
      <td align="center">Insentif</td>
      <td align="center">Total</td>
      <td align="center">Insentif</td>
    </tr>
  </td>
  <td>
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
        <td>Rp. {{$kon_listNominalHM == 0?'-':$kon_listNominalHM}}</td>
        <td>{{array_get($listTrip,$date->format('Y-m-d'))}}</td>
        <td>Rp. {{$kon_listNominalTrip == 0?'-':$kon_listNominalTrip}}</td>
      </tr>
    @endfor
  </td>
  <table>
    <tr>
      <td>DOH</td>
      <td>:</td>
      <td>{{$sekarang->format('d-M-Y')}}</td>
    </tr>
    <tr>
      <td>NPWP</td>
      <td>:</td>
      <td>{{$karyawan->npwp}}</td>
    </tr>
  </table>

  <div class="col-md-12" >
    <div class="row">
      <div class="col-md-8">
        <div class="table-wrapper">
          <table class="table table-custom table-bordered table-sm table-absen">
            <thead>
              <tr class="table-primary">
                <th rowspan = "2">No</th>
                <th rowspan = "2">Tanggal</th>
                <th rowspan = "2">Hari</th>
                <th rowspan = "2">Status</th>
                <th colspan = "2">HM</th>
                <th colspan = "2">TRIP</th>
              </tr>
              <tr class="table-primary">
                <th>Total</th>
                <th>Insentif</th>
                <th>Total</th>
                <th>Insentif</th>
              </tr>
            </thead>
            <tbody>
              @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                @php
                  $kon_listNominalHM   = number_format(array_get($listNominalHM,$date->format('Y-m-d')),2,",",".");
                  $kon_listNominalTrip = number_format(array_get($listNominalTrip,$date->format('Y-m-d')),2,",",".");
                @endphp
                <tr>
                  <td>{{$date->format('d')}}</td>
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
      <div class="col-md-4">
        @include('slip.kotak_kanan')
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
        @include('slip.kotak_bawah')
      </div>
      <div class="col-md-6">
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
  <br><br><br><br>
</html>
