<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr>
      <th width="30">No</th>
      <th>Ijin Resmi</th>
      <th>Ijin Tidak Resmi</th>
      <th>Sakit Surat Dokter</th>
      <th>Sakit Tanpa Surat</th>
      <th>Alpha</th>
      <th>Baru/Keluar</th>
      <th>Setengah Hari</th>
      <th>Cuti</th>
      <th>Libur Nasional</th>
      <th>Minggu</th>
      <th>OFF</th>
      <th>Lembur</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($setAbsen as $index => $item)
      @php
          $numNominal = number_format($item->nominal,2) ;
      @endphp
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td nowrap>Rp. {{number_format($item->ir,2)}}</td>
        <td nowrap>Rp. {{number_format($item->i,2)}}</td>
        <td nowrap>Rp. {{number_format($item->s,2)}}</td>
        <td nowrap>Rp. {{number_format($item->s1,2)}}</td>
        <td nowrap>Rp. {{number_format($item->a,2)}}</td>
        <td nowrap>Rp. {{number_format($item->x,2)}}</td>
        <td nowrap>Rp. {{number_format($item->mi,2)}}</td>
        <td nowrap>Rp. {{number_format($item->ct,2)}}</td>
        <td nowrap>Rp. {{number_format($item->l,2)}}</td>
        <td nowrap>Rp. {{number_format($item->m,2)}}</td>
        <td nowrap>Rp. {{number_format($item->off,2)}}</td>
        <td nowrap>Rp. {{number_format($item->lembur,2)}}</td>
        <td nowrap>
          <a href="{{ route('setabsen.edit', $item->id) }}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('setabsen.destroy', $item->id) }}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger" title="Hapus Data">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="13" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{!! $setAbsen->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
