<table style="font-size:16px">
  <tr>
    <td>NIK</td>
    <td>:</td>
    <td>{{$biodata->karyawan()->where('biodata_id',$biodata->id)->value('nik')}}</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td>{{$biodata->nama_lengkap}}</td>
  </tr>
  <tr>
    <td>Divisi</td>
    <td>:</td>
    <td>{{$biodata->karyawan()->where('biodata_id',$biodata->id)->value('divisi')}}</td>
  </tr>
</table>
