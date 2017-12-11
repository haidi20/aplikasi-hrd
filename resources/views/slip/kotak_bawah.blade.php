<table border="1" style="text-align:center" class="table table-custom table-bordered table-sm table-absen">
  <thead>
    <tr>
      <th colspan="4">Kehadiran</th>
    </tr>
    <tr>
      <th>Kode</th>
      <th>Keterangan</th>
      <th>Kode</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      @foreach ($keteranganAbsenA as $index => $item)
        @if ($index == 'H' || $index == 'Mi')
          <td>{{$index}}</td>
          <td>{{$item}}</td>
        @elseif ($index == 'IR' || $index == 'CT')
          <td>{{$index}}</td>
          <td>{{$item}}</td>
        @elseif ($index == 'I' || $index == 'L')
          <td>{{$index}}</td>
          <td>{{$item}}</td>
        @elseif ($index == 'S' || $index == 'M')
          <td>{{$index}}</td>
          <td>{{$item}}</td>
        @elseif ($index == 'S1' || $index == 'OFF')
          <td>{{$index}}</td>
          <td>{{$item}}</td>
        @elseif ($index == 'A' || $index == 'X')
          <td>{{$index}}</td>
          <td>{{$item}}</td>
        @elseif ($index == 'pindah1' || $index == 'pindah2' || $index == 'pindah3' || $index == 'pindah4' || $index == 'pindah5')
          <tr></tr>
        @endif
      @endforeach
  </tr>
  </tbody>
  <thead>
    <tr>
      <th>Kode</th>
      <th>Jumlah Hari</th>
      <th>Kode</th>
      <th>Jumlah Hari</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      @foreach ($keteranganAbsenA as $index => $item)
        @if ($index == 'H' || $index == 'Mi')
          <td>{{$index}}</td>
          <td>{{count($jumlahAbsen[$index])}}</td>
        @elseif ($index == 'IR' || $index == 'CT')
          <td>{{$index}}</td>
          <td>{{count($jumlahAbsen[$index])}}</td>
        @elseif ($index == 'I' || $index == 'L')
          <td>{{$index}}</td>
          <td>{{count($jumlahAbsen[$index])}}</td>
        @elseif ($index == 'S' || $index == 'M')
          <td>{{$index}}</td>
          <td>{{count($jumlahAbsen[$index])}}</td>
        @elseif ($index == 'S1' || $index == 'OFF')
          <td>{{$index}}</td>
          <td>{{count($jumlahAbsen[$index])}}</td>
        @elseif ($index == 'A' || $index == 'X')
          <td>{{$index}}</td>
          <td>{{count($jumlahAbsen[$index])}}</td>
        @elseif ($index == 'pindah1' || $index == 'pindah2' || $index == 'pindah3' || $index == 'pindah4' || $index == 'pindah5')
          <tr></tr>
        @endif
      @endforeach
  </tr>
  </tbody>
</table>
