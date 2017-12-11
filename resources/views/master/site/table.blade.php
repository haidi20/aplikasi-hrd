<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr>
      <th width="60">No</th>
      <th width="100">Kode</th>
      <th>Lokasi</th>
      <th width="60">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($site as $index => $item)
      <tr>
        <td>{{$index + 1}}</td>
        <td>{{$item->kode}}</td>
        <td>{{$item->lokasi}}</td>
        <td class="text-center">
          {{-- {{ route('master::karyawan.edit',$item->id)}} --}}
          <a href="{{ route('master::site.edit',$item->id)}}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::site.destroy',$item->id)}}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger" title="Hapus Data">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="28" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{{-- {!! $departemen->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!} --}}
