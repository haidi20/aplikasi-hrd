<table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr align="center">
      <th width="30">No</th>
      <th>Tanggal</th>
      <th>Shift</th>
      <th>Jam</th>
      <th>Unit</th>
      <th>Departemen</th>
      <th>Driver</th>
      <th>NIK</th>
      <th>Tipe</th>
      <th>Kode Seam</th>
      <th>Trip</th>
      <th>Tonase</th>
      <th>Jarak</th>
      <th>Ton.KM</th>
      <th>Pembayaran</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($hauling as $index => $item)
      @if ($item->karyawan && $item->karyawan->biodata && $item->karyawan->departemen)
        @php
            if ($hauling->currentPage() >= 1) {
                $no = (($hauling->currentPage() * 10) - 10) + $index + 1 ;
            }
        @endphp
        <tr align="center">
          <td>{{$no}}</td>
          <td>{{$item->tanggal}}</td>
          <td>{{$item->shift}}</td>
          <td>{{$totalJam[$item->id] != 0?$totalJam[$item->id]:''}}</td>
          <td>{{$item->alat->nama}}</td>
          <td>{{$item->karyawan->departemen->nama}}</td>
          <td>{{$item->karyawan->biodata->nama_lengkap}}</td>
          <td>{{$item->karyawan->nik}}</td>
          <td>{{$item->tipe}}</td>
          <td>{{$item->seam}}</td>
          <td>{{$item->trip}}</td>
          <td>{{$totalTonase[$item->id] != 0?$totalTonase[$item->id]:''}}</td>
          <td>{{$item->jarak}}</td>
          <td>{{$total[$item->id] != 0?$total[$item->id]:''}}</td>
          <td>{{$item->pembayaran == 0?'-':'Rp.'.number_format($item->pembayaran,2) }}</td>
          <td>
            {{-- {{ route('master::hauling.edit', $item->id) }} --}}
            <a href="{{route('waktu-hauling.index',['hauling_id'=>$item->id])}}"
              class="btn btn-xs btn-outline-success" title="Data Waktu-Hauling">
              <i class="fa fa-list-alt"></i>
            </a>
            <a href="{{ route('hauling.edit', $item->id) }}"
              class="btn btn-xs btn-outline-secondary" title="Edit Data">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="{{route('hauling.destroy',$item->id)}}"
              data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
              class="btn btn-xs btn-outline-danger" title="Hapus Data">
              <i class="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
      @endif
    @empty
      <tr>
        <td colspan="16" align="center">Tidak ada data</td>
      </tr>
    @endforelse
  </tbody>
</table>
{!! $hauling->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
