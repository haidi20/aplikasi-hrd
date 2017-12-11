<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr>
      <th width="30">No</th>
      <th nowrap>Anggaran Trip 1 - 4</th>
      <th nowrap>Anggaran Trip 5 dan seterusnya</th>
      <th nowrap>Bonus Anggaran Jumlah Trip 120</th>
      <th nowrap>Anggaran Alat Spesial</th>
      <th nowrap>Anggaran Alat Biasa</th>
      {{-- <th nowrap>SA Harian</th> --}}
      <th nowrap>PPH21</th>
      <th nowrap>Batas Jam Alat</th>
      <th nowrap>Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($pengaturan as $index => $item)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>{{$item->biasa == 0?'-':' Rp.'.number_format($item->biasa,2) }}</td>
        <td>{{$item->lumayan == 0?'-':' Rp.'.number_format($item->lumayan,2) }}</td>
        <td>{{$item->bonus == 0?'-':' Rp.'.number_format($item->bonus,2) }}</td>
        <td>{{$item->alat_spesial == 0?'-':' Rp.'.number_format($item->alat_spesial,2)}}</td>
        <td>{{$item->alat_biasa == 0?'-':' Rp.'.number_format($item->alat_biasa,2) }}</td>
        {{-- <td>{{$item->sa_harian == 0?'-':' Rp.'.number_format($item->sa_harian,2) }}</td> --}}
        <td>{{$item->pph21 == 0?'-':' Rp.'.number_format($item->pph21,2) }}</td>
        <td>{{$item->jam_alat == 0?'-':$item->jam_alat}}</td>
        <td class="text-center">
          <a href="{{ route('pengaturan.edit', $item->id) }}"
            class="btn btn-xs btn-outline-secondary">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('pengaturan.destroy', $item->id) }}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="11" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{!! $pengaturan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
