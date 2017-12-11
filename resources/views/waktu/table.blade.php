<div class="col-md-12">
  <div class="row">
    @include('waktu.identitas')
  </div>
</div>
<br>
<div class="col-md-12" style="overflow:scroll;max-width:100%;">
  <table class="table table-bordered table-custom table-hover table-striped table-md">
  <thead>
    <tr>
      <th width="20px">No.</th>
      <th width="40px">Waktu</th>
      <th>Tonase</th>
      <th align="center">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($waktu as $index => $item)
      <tr>
        <td>{{$index + 1}}</td>
        <td>{{$item->jam}}</td>
        <td>{{$item->tonase}}</td>
        <td nowrap width="70px">
          <a href="{{route('waktu-hauling.edit',$item->id)}}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{route('waktu-hauling.destroy',$item->id)}}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger" title="Hapus Data">
            <i class="fa fa-trash-o"></i>
          </a>
        </td>
      </tr>
    @empty
      <tr align="center">
        <td colspan="4">Tidak Ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>
</div>

{{-- {!! $biodata->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!} --}}
