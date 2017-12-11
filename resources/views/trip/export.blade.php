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
    @if ($item->karyawan->biodata && $item->karyawan)
      @php
        $numTotalNominalTrip = number_format($totalNominalTrip[$item->karyawan->id],2);
      @endphp
      <tr>
        <td align="center">{{$index + 1}}</td>
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
</html>
