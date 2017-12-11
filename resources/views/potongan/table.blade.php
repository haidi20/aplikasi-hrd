<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr>
      <th width="30">No</th>
      <th>NIK</th>
      <th>Karyawan</th>
      <th>Kategori</th>
      <th>keterangan</th>
      <th>Nominal</th>
      <th>Tanggal</th>
      <th width="120">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($potongan as $index => $item)
      @if ($item->karyawan && $item->karyawan->biodata)
        @php
            $numNominal = number_format($item->nominal,2) ;
        @endphp
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td>{{$item->karyawan->nik}}</td>
          <td>{{$item->karyawan->biodata->nama_lengkap}}</td>
          <td>{{$item->kategori}}</td>
          <td>{{$item->keterangan}}</td>
          <td>Rp. {{$numNominal == 0?'':$numNominal}}</td>
          <td>{{$item->tanggal}}</td>
          <td class="text-center">
            <a href="{{ route('potongan.edit', $item->id) }}"
              class="btn btn-xs btn-outline-secondary" title="Edit Data">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="{{ route('potongan.destroy', $item->id) }}"
              data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
              class="btn btn-xs btn-outline-danger" title="Hapus Data">
              <i class="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
      @endif
    @empty
      <tr>
        <td colspan="6" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{!! $potongan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
