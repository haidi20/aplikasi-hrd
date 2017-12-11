<html>
  <tr>
    <td>PT. SAMUDRA MAJU PERKASA</td>
  </tr>
  <tr>
    <td>JOB SITE GAM</td>
  </tr>
  <tr>
    <td>REKAP GAJI DEPARTEMEN PRODUKSI</td>
  </tr>
  <tr>
    <td>{{$tahunSekarang->format('d-M-Y')}}</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <th rowspan="3" align="center">No</th>
    <th rowspan="3" align="center">Nama Karyawan</th>
    <th colspan="{{ $mulai->copy()->endOfMonth()->format('j') }}" align="center">
      Bulan {{ trans('date.month.key.full.' . $mulai->format('n')) }} Tanggal
    </th>
    <th rowspan="3" align="center">Total</th>
    <tr>
      <th></th>
      <th></th>
      @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
        <th align="center">{{ $date->format('d') }}</th>
      @endfor
    </tr>
    <tr>
      <th></th>
      <th></th>
      @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
        <th align="center">{{ trans('date.day.' . $date->format('l')) }}</th>
      @endfor
    </tr>
  </tr>
  @forelse ($karyawan as $index => $item)
    @php
      $total_harga=number_format(array_get($totalHarga,$item->karyawan->id),2);
    @endphp
    <tr>
      <td align="center">{{$index + 1}}</td>
      <td nowrap>{{$item->karyawan->biodata->nama_lengkap}}</td>
      {{-- $date->format('Y-m-d') --}}
      @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
        @php
          $angka_meter = number_format(array_get($meter[$date->format('Y-m-d')],$item->karyawan->id),2) ;
        @endphp
        <td nowrap>{{$angka_meter == 0?'':'Rp. '.$angka_meter}}</td>
      @endfor
      <td nowrap>{{$total_harga == 0?'':'Rp. '.$total_harga}}</td>
    </tr>
  @empty
    <tr colspan={{$akhir->format('d')+3}}>
      <td>Data Tidak Ada</td>
    </tr>
  @endforelse
</html>
