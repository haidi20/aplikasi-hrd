<table>
  <tr>
    <td width="100%"></td>
    <form action="{{route('trip.export',['bulan'=>request('bulan'),'tahun' => request('tahun')])}}" method="get">
      <input type="hidden" name="bulan" value="{{request('bulan')}}">
      <input type="hidden" name="tahun" value="{{request('tahun')}}">
    <td><button type="submit">Export</button></td>
  </form>
  </tr>
</table>
<div class="col-md-12" style="overflow:scroll;max-width:100%;">
  <div class="table-wrapper">
    <table border="1">
      <thead>
        <tr class="table-primary">
          <th rowspan="3">No</th>
          <th rowspan="3">Nama Karyawan</th>
          <th colspan="{{ $mulai->copy()->endOfMonth()->format('j') }}" class="text-center">
            Bulan {{ trans('date.month.key.full.' . $mulai->format('n')) }} Tanggal
          </th>
          <th rowspan="3">Total</th>
          <tr class="table-primary">
            @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
              <th>{{ $date->format('d') }}</th>
            @endfor
          </tr>
          <tr class="table-primary">
            @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
              <th>{{ trans('date.day.' . $date->format('l')) }}</th>
            @endfor
          </tr>
        </tr>
      </thead>
      <tbody>
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
      </tbody>
    </table>
  </div>
</div>
