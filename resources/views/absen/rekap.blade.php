{{-- @extends('_layout.basic') --}}
  {{-- <div class="container"> --}}
  <table>
    <tr>
      <td width="100%"></td>
      <form action="{{route('absen.export',['bulan'=>request('bulan'),'tahun'=>request('tahun')])}}" method="get">
        <input type="hidden" name="bulan" value="{{request('bulan')}}">
        <input type="hidden" name="tahun" value="{{request('tahun')}}">
      <td><button type="submit">Export</button></td>
    </form>
    </tr>
  </table>
  <div class="col-md-12" style="overflow:scroll;max-width:100%;">
    <div class="table-wrapper">
      <table class="table table-custom table-bordered table-sm table-absen" border="1">
        <thead>
          <tr class="table-primary">
            <th rowspan="3">No.</th>
            <th rowspan="3">Nama Karyawan</th>
            <th colspan="{{ $mulai->copy()->endOfMonth()->format('j') }}" class="text-center">
              Bulan {{ trans('date.month.key.full.' . $mulai->format('n')) }} Tanggal
            </th>
            <th rowspan="3">Total</th>
          </tr>
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
        </thead>
        <tbody>
          @forelse ($karyawan as $index => $item)
            <tr>
              <td align="center" >{{ $index + 1 }}</td>
              <td nowrap>{{ $item->biodata->nama_lengkap }}</td>
              @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                <td class="has-select {{ array_get($listAbsen[$date->format('Y-m-d')], $item->id) }}">
                  {{ array_get($listAbsen[$date->format('Y-m-d')], $item->id) }}
                </td>
              @endfor
              <td>{{array_get($totalAbsen,$item->id)}}</td>
            </tr>
          @empty
            <tr>
              <td colspan="{{ $akhir->format('d') + 2 }}" align="center">Tidak ada data</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  </div>
