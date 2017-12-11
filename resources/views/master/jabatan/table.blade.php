<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr align="center">
      <th width="30" class="text-center">No</th>
      <th width="100" class="text-center">Kode</th>
      <th>Nama Jabatan</th>
      <th width="120" class="text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($jabatan as $index => $item)
      @php
          if ($jabatan->currentPage() >= 1) {
              $no = (($jabatan->currentPage() * 10) - 10) + $index + 1 ;
          }
      @endphp
      <tr>
        <td>{{$no}}</td>
        <td>{{$item->kode}}</td>
        <td>{{$item->nama}}</td>
        <td>
          <a href="{{ route('master::jabatan.edit',$item->id)}}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::jabatan.destroy',$item->id)}}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini ?"
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
{!! $jabatan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
