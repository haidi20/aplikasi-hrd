<table>
  <tr>
    <td width="100%"></td>
    <form action="{{route('meter.export',['bulan'=>request('bulan'),'tahun' => request('tahun')])}}" method="get">
      <input type="hidden" name="bulan" value="{{request('bulan')}}">
      <input type="hidden" name="tahun" value="{{request('tahun')}}">
    <td><button type="submit">Export</button></td>
  </form>
  </tr>
</table>
<div class="col-md-12" style="overflow:scroll;max-width:100%;" >
  <div class="table-wrapper">
    <table class="table table-custom table-bordered table-sm table-absen" border="1">
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
        @foreach ($karyawan as $index => $item)
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
        @endforeach
      </tbody>
    </table>
  </div>
</div>
