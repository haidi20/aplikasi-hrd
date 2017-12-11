<div class="col-md-12" style="overflow:scroll; max-width:100%;">
  <div class="table-wrapper">
    <table class="table table-bordered table-custom table-hover table-striped table-sm">
      <thead>
        <tr>
          <th nowrap>No</th>
          <th nowrap>NIK</th>
          <th nowrap>Nama</th>
          <th nowrap>Departemen</th>
          <th nowrap>Jabatan</th>
          <th nowrap>Divisi</th>
          <th nowrap>Nama Atasan</th>
          <th nowrap>Golongan</th>
          <th nowrap>Status</th>
          <th nowrap>Gapok</th>
          <th nowrap>Uang Makan</th>
          <th nowrap>SA Harian</th>
          <th nowrap>Tunjangan Jabatan</th>
          <th nowrap>Tanggal Masuk</th>
          <th nowrap>Tanggal Keluar</th>
          <th nowrap>Status Kerja</th>
          <th nowrap>Jenis Kerja</th>
          <th nowrap>Masa Kerja</th>
          <th nowrap>kode</th>
          <th nowrap>NRP</th>
          <th nowrap>Site</th>
          <th nowrap>Nomor NPWP</th>
          <th nowrap>Nomor JAMSOSTEK</th>
          <th nowrap>Nomor Rekening</th>
          <th nowrap>Jenis Bank</th>
          <th nowrap>Cabang Bank</th>
          <th nowrap>Cara Bayar</th>
          <th nowrap>Nomor BPJS</th>
          <th nowrap>Biaya BPJS Tenaga Kerja</th>
          <th nowrap>Biaya BPJS Kesehatan</th>
          <th nowrap>Status Perikahan</th>
          <th nowrap>Fiskal</th>
          <th nowrap>SIM A</th>
          <th nowrap>SIM B</th>
          <th nowrap>SIM B2</th>
          <th nowrap>SIM C</th>
          <th nowrap>SIMPer</th>
          <th nowrap>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($karyawan as $index => $item)
          @if ($item->biodata && $item->departemen && $item->jabatan && $item->site)
            @php
              if ($karyawan->currentPage() >= 1) {
                  $no = (($karyawan->currentPage() * 10) - 10) + $index + 1 ;
              }
              $numGapok               = number_format($item->gapok,2,",",".");
              $numUangMakan           = number_format($item->uang_makan,2,",",".");
              $numSaHarian            = number_format($item->sa_harian,2,",",".");
              $numTunjangan           = number_format($item->tunjangan,2,",",".");
          @endphp
          <tr>
            <td nowrap>{{ $no }}</td>
            <td nowrap>{{ $item->nik}}</td>
            <td nowrap>{{ $item->biodata->nama_lengkap }}</td>
            <td nowrap>{{ $item->departemen->nama }}</td>
            <td nowrap>{{ $item->jabatan->nama }}</td>
            <td nowrap>{{ $item->divisi }}</td>
            <td nowrap>{{ $item->nama_atasan }}</td>
            <td nowrap>{{ $item->golongan }}</td>
            <td nowrap>{{ $item->status }}</td>
            <td nowrap>Rp. {{ $numGapok == 0?'-':$numGapok }}</td>
            <td nowrap>Rp. {{ $numUangMakan == 0?'-':$numUangMakan }}</td>
            <td nowrap>Rp. {{ $numSaHarian == 0?'-':$numSaHarian }}</td>
            <td nowrap>Rp. {{ $numTunjangan == 0?'-':$numTunjangan}}</td>
            <td nowrap>{{ $item->tanggal_masuk }}</td>
            <td nowrap>{{ $item->tanggal_keluar }}</td>
            <td nowrap>{{ $item->status_kerja }}</td>
            <td nowrap>{{ $item->jenis_kerja}}</td>
            <td nowrap>{{ empty($item->masa_kerja)?'':$item->masa_kerja }}</td>
            <td nowrap>{{ $item->kode }}</td>
            <td nowrap>{{ $item->nrp }}</td>
            <td nowrap>{{ $item->site->lokasi }}</td>
            <td nowrap>{{ $item->npwp == 0? '':$item->npwp }}</td>
            <td nowrap>{{ $item->jamsostek == 0? '':$item->jamsostek }}</td>
            <td nowrap>{{ $item->rekening == 0?'':$item->rekening }}</td>
            <td nowrap>{{ $item->jenis_bank }}</td>
            <td nowrap>{{ $item->cabang_bank }}</td>
            <td nowrap>{{ $item->cara_bayar }}</td>
            <td nowrap>{{ $item->bpjs == 0?'':$item->bpjs }}</td>
            <td nowrap>Rp. {{ $item->bpjs_tk == 0?'-':number_format($item->bpjs_tk,2,",",".") }}</td>
            <td nowrap>Rp. {{ $item->bpjs_kes == 0?'-':number_format($item->bpjs_kes,2,",",".") }}</td>
            <td nowrap>{{ $item->status_pernikahan }}</td>
            <td nowrap>{{ $item->fiskal }}</td>
            <td nowrap>{{ $item->sim_a }}</td>
            <td nowrap>{{ $item->sim_b }}</td>
            <td nowrap>{{ $item->sim_b2 }}</td>
            <td nowrap>{{ $item->sim_c }}</td>
            <td nowrap>{{ $item->simper }}</td>
            <td class="text-center" nowrap>
              <a href="{{ route('master::karyawan.edit',$item->id)}}"
                class="btn btn-xs btn-outline-secondary" title="Edit Data">
                <i class="fa fa-pencil"></i>
              </a>
              <a href="{{ route('master::karyawan.destroy',$item->id)}}"
                data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
                class="btn btn-xs btn-outline-danger" title="Hapus Data">
                <i class="fa fa-trash-o"></i>
              </a>
            </td>
          </tr>
          @endif
        @empty
          <tr>
            <td colspan="38" align="center">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
{!! $karyawan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
