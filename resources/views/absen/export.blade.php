<html>
  <tr>
    <td colspan="15">PT. SAMUDRA MAJU PERKASA</td>
  </tr>
  <tr>
    <td colspan="15">JOB SITE GAM</td>
  </tr>
  <tr>
    <td colspan="15">REKAP GAJI DEPARTEMEN PRODUKSI</td>
  </tr>
  <tr>
    <td colspan="15">{{$sekarang->format('d-M-Y')}}</td>
  </tr>
  <tr>
    <td colspan="15"></td>
  </tr>
  <tr>
    <td rowspan="2" align="center">No.</td>
    <td rowspan="2" align="center">Nama Karyawan</td>
    <td colspan="12" align="center">Keterangan</td>
    <td rowspan="2" align="center">Total</td>
  </tr>
  <tr>
    @foreach ($kodeAbsen as $item)
      <td>{{$item}}</td>
    @endforeach
  </tr>
  @forelse ($karyawan as $index => $item)
    <tr>
      <td>{{$index + 1}}</td>
      <td>{{$item->biodata->nama_lengkap}}</td>
      @foreach ($jmlAbsen as $index2 => $item2)
          <td>{{array_get($item2,$item->id)}}</td>
      @endforeach
      <td>{{array_get($totalAbsen,$item->id)}}</td>
    </tr>
  @empty
    <tr>
      <td colspan="" align="center">Tidak ada data</td>
    </tr>
  @endforelse
</html>
