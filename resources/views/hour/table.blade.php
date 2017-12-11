<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr align="center">
      <th width="30px">No</th>
      <th>Tanggal</th>
      <th>Shift</th>
      <th>Unit</th>
      <th>Mulai</th>
      <th>Selesai</th>
      <th>Mulai Desimal</th>
      <th>Selesai Desimal</th>
      <th>Total Desimal</th>
      {{-- <th>Total</th> --}}
      <th>Departemen</th>
      <th>Driver</th>
      <th>NIK</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($hour as $index => $item)
      @if ($item->alat && $item->karyawan && $item->karyawan->biodata && $item->karyawan->departemen)
        @php
            if ($hour->currentPage() >= 1) {
                $no = (($hour->currentPage() * 10) - 10) + $index + 1 ;
            }
        @endphp
        <tr align="center">
          <td>{{$no}}</td>
          <td>{{$item->tanggal}}</td>
          <td>{{$item->shift}}</td>
          <td>{{$item->alat->nama}}</td>
          <td>{{$item->mulai}}</td>
          <td>{{$item->selesai}}</td>
          <td>{{$item->mulai_des}}</td>
          <td>{{$item->selesai_des}}</td>
          <td>{{$item->total_des}}</td>
          {{-- <td>{{number_format($total[$index],1)}}</td> --}}
          <td>{{$item->karyawan->departemen->nama}}</td>
          <td>{{$item->karyawan->biodata->nama_lengkap}}</td>
          <td>{{$item->karyawan->nik}}</td>
          <td>
            <a href="{{ route('hour.edit', $item->id) }}"
              class="btn btn-xs btn-outline-secondary" title="Edit Data">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="{{route('hour.destroy',$item->id)}}"
              data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
              class="btn btn-xs btn-outline-danger" title="Hapus Data">
              <i class="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
      @endif
    @empty
      <tr>
        <td colspan="10" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>
{!! $hour->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
