<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr align="center">
      <th width="30">No</th>
      <th nowrap>Nama</th>
      <th nowrap>Kategori</th>
      <th nowrap>Status</th>
      <th nowrap width="80">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($alat as $index => $item)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->kategori }}</td>
        <td>{{ $item->status }}</td>
        <td class="text-center">
          <a href="{{ route('master::alat.edit', $item->id) }}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::alat.destroy', $item->id) }}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger" title="Hapus Data">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{!! $alat->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
