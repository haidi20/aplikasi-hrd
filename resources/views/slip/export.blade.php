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
      @for ($i=1; $i <=5 ; $i++)
        <td></td>
      @endfor
      <td>DOH</td>
      <td align="center">:</td>
      <td>{{$sekarang->format('d-M-Y')}}</td>
    </tr>
    <tr>
      <td>Departemen</td>
      <td></td>
      <td align="center">:</td>
      <td>{{$karyawan->departemen->nama}}</td>
      @for ($i=1; $i <=5 ; $i++)
        <td></td>
      @endfor
      <td>NPWP</td>
      <td align="center">:</td>
      <td align="left">{{$karyawan->npwp}}</td>
    </tr>
  </td>
  <td>
    <tr class="table-primary">
      <td align="center">No</td>
      <td align="center">Tanggal</td>
      <td align="center">Hari</td>
      <td align="center">Status</td>
      <td align="center">HM</td>
      <td></td>
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
  <td>
    <table width="100%">
      <tr>
        <td>Gaji Pokok</td>
        <td>Rp.{{number_format($karyawan->gapok,2,",",".")}}</td>
      </tr>
      <tr>
        <td>Pendapatan</td>
        <td></td>
      </tr>
      <tr>
        <td>Total Trip</td>
        <td>{{array_get($trip,$karyawan->id) == 0?0:array_get($trip,$karyawan->id)}}</td>
      </tr>
      <tr>
        <td>Insentif Trip</td>
        <td>Rp.{{number_format(array_get($nominalTrip,$karyawan->id),2,",",".")}}</td>
      </tr>
      <tr>
        <td>Total HM</td>
        <td>{{array_get($HM,$karyawan->id) == 0?0:array_get($HM,$karyawan->id)}}</td>
      </tr>
      <tr>
        <td>Insentif HM</td>
        <td>Rp.{{number_format(array_get($nominalHM,$karyawan->id),2,",",".")}}</td>
      </tr>
      <tr>
        <td>Uang Makan</td>
        <td>Rp.{{number_format($karyawan->uang_makan,2,",",".")}}</td>
      </tr>
      <tr>
        <td>Total Upah Kotor</td>
        <td>Rp.{{number_format($totalPendapatan,2,",",".")}}</td>
      </tr>
    </table>
  </td>
</html>
