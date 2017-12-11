<div class="col-md-12" style="max-width:100%;">
  <table class="table table-bordered table-custom table-hover table-striped table-sm">
    <thead>
      <tr>
        <th width="20px">No.</th>
        <th>Email</th>
        <th width="60px">Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($mail as $index => $item)
        <tr>
          <td align="center">{{$index + 1}}</td>
          <td>{{$item->email}}</td>
          <td>
            <a href="{{route('setemail.edit',$item->id)}}"
              class="btn btn-xs btn-primary" title="Edit Data">
              <li class="fa fa-pencil"></li>
            </a>
            <a href="{{route('setemail.destroy',$item->id)}}"
              data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini ?"
              class="btn btn-xs btn-danger" title="Hapus Data">
              <li class="fa fa-trash-o"></li>
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" align="center">Tidak Ada Data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
