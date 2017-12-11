<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr>
      <th width="30">No</th>
      <th width="100">Kode</th>
      <th>Nama</th>
      <th width="120">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($departemen as $index => $item)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td class="text-center">{{ $item->kode }}</td>
        <td>{{ $item->nama }}</td>
        <td class="text-center">
          <a href="{{ route('master::departemen.edit', $item->id) }}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::departemen.destroy', $item->id) }}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger" title="Hapus Data">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="4" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{!! $departemen->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
