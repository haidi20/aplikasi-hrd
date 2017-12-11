<div class="col-md-12">
  <div class="row">
    @include('master.keluarga.identitas')
  </div>
</div>
<br>
<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr align="center">
      <th width="30">No</th>
      <th>Jenis</th>
      <th>Nama</th>
      <th>Tanggal Lahir</th>
      <th>Pendidikan Terakhir</th>
      <th>Pekerjaan</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($keluarga as $index => $item)
      <tr align="center">
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->jenis }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->tanggal_lahir }}</td>
        <td>{{ $item->pendidikan_terakhir }}</td>
        <td>{{ $item->pekerjaan}}</td>
        <td>
          {{-- <a href="{{ route('master::keluarga.edit',$item->id) }}" --}}
          <a href="{{ route('master::keluarga.editt',['biodata_id'=>request('biodata_id'),'id' => $item->id]) }}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::keluarga.destroy', $item->id) }}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger" title="Hapus Data">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr align="center">
        <td colspan="7">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>

{{-- {!! $departemen->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!} --}}
