<div class="col-md-12" style="overflow:scroll;max-width:100%;">
  <table class="table table-bordered table-custom table-hover table-striped table-sm">
  <thead>
    <tr align="center">
      <th width="20px">No.</th>
      <th>Nama Depan</th>
      <th>Nama Belakang</th>
      <th width="100px">Nama Panggilan</th>
      <th width="150px">Nama Lengkap</th>
      <th width="90px">Tempat Lahir</th>
      <th width="90px">Tanggal Lahir</th>
      <th width="40px">Status</th>
      <th>Alamat</th>
      <th width="60px">Agama</th>
      <th>KTP</th>
      <th width="90px">Tanggal Akhir KTP </th>
      <th>Kewarganegaraan</th>
      <th>WNI</th>
      <th>WNA</th>
      <th>RT</th>
      <th>RW</th>
      <th>Kecamatan</th>
      <th>Kelurahan</th>
      <th>Kota</th>
      <th>Status Rumah</th>
      <th width="50px">Pendidikan Terakhir</th>
      {{-- <th>Pendidikan Terakhir</th> --}}
      <th>Instansi Pendidikan</th>
      <th>Jurusan</th>
      <th>Tahun Masuk</th>
      <th>Tahun Kelulusan</th>
      <th>Nilai Terakhir</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($biodata as $index => $item)
      @php
          if ($biodata->currentPage() >= 1) {
              $no = (($biodata->currentPage() * 10) - 10) + $index + 1 ;
          }
      @endphp
      <tr>
        <td>{{$no}}</td>
        <td nowrap>{{$item->nama_depan}}</td>
        <td nowrap>{{$item->nama_belakang}}</td>
        <td nowrap>{{$item->nama_panggilan}}</td>
        <td nowrap>{{$item->nama_lengkap}}</td>
        <td nowrap>{{$item->tempat_lahir}}</td>
        <td nowrap>{{$item->tanggal_lahir}}</td>
        <td nowrap>{{$item->status}}</td>
        <td nowrap>{{$item->alamat}}</td>
        <td nowrap>{{$item->agama}}</td>
        <td nowrap>{{$item->ktp}}</td>
        <td nowrap>{{$item->akhir_ktp}}</td>
        <td nowrap>{{$item->kewarganegaraan}}</td>
        <td nowrap align="center">{!!$item->warganegara == 'wni'?'<i class="fa fa-check" aria-hidden="true"></i>':''!!}</td>
        <td nowrap align="center">{!!$item->warganegara == 'wna'?'<i class="fa fa-check" aria-hidden="true"></i>':''!!}</td>
        <td nowrap>{{$item->rt}}</td>
        <td nowrap>{{$item->rw}}</td>
        <td nowrap>{{$item->kecamatan}}</td>
        <td nowrap>{{$item->kelurahan}}</td>
        <td nowrap>{{$item->kota}}</td>
        <td nowrap>{{$item->status_rumah}}</td>
        <td nowrap>{{$item->pendidikan}}</td>
        {{-- <td nowrap>{{$item->pendidikan_terakhir}}</td> --}}
        <td nowrap>{{$item->instansi_pendidikan}}</td>
        <td nowrap>{{$item->jurusan}}</td>
        <td nowrap>{{$item->tahun_masuk}}</td>
        <td nowrap>{{$item->tahun_kelulusan}}</td>
        <td nowrap>{{$item->nilai_akhir}}</td>
        <td nowrap class="text-center">
          <a href="{{route('master::keluarga.index',['biodata_id'=>$item->id])}}"
            class="btn btn-xs btn-outline-success" title="Data Keluarga">
            <i class="fa fa-list-alt"></i>
          </a>
          <a href="{{ route('master::biodata.edit',$item->id)}}"
            class="btn btn-xs btn-outline-secondary" title="Edit Data">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::biodata.destroy',$item->id)}}"
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
</div>

{!! $biodata->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
