@if ($karyawan->karyawan && $karyawan->karyawan->biodata)
  <table style="font-size:16px">
    <tr>
      <td>NIK</td>
      <td>:</td>
      <td>{{$karyawan->karyawan->biodata->nik}}</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>{{$karyawan->karyawan->biodata->nama_lengkap}}</td>
    </tr>
    <tr>
      <td>Divisi</td>
      <td>:</td>
      <td>{{$karyawan->karyawan->biodata->divisi}}</td>
    </tr>
  </table>
@endif
