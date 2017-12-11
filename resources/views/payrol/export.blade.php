<html>
  <tr>
    <td>PT. SAMUDRA MAJU PERKASA</td>
  </tr>
  <tr>
    <td>JOB SITE GAM</td>
  </tr>
  <tr>
    <td>REKAP GAJI DEPARTEMEN PRODUKSI</td>
  </tr>
  <tr>
    <td>{{$tahunSekarang->format('d-M-Y')}}</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr align="center" border="1">
    <td align="center">No</td>
    <td align="center">Kode</td>
    <td align="center">NRP</td>
    <td align="center">Nama Karyawan</td>
    <td align="center">GOL</td>
    <td align="center">Jabatan</td>
    <td align="center">Departemen</td>
    <td align="center">Gaji Pokok</td>
    <td align="center">Gaji Proposional</td>
    <td align="center">Absensi</td>
    @for ($i=1; $i <=12 ; $i++)
      <td></td>
    @endfor
    <td align="center">Pendapatan Tidak Tetap</td>
    @for ($i=1; $i <4 ; $i++)
      <td></td>
    @endfor
    <td align="center">Produksi</td>
    @for ($i=1; $i <5 ; $i++)
      <td></td>
    @endfor
    <td align="center">Rapel / Lain-lain</td>
    <td align="center">TOTAL PENDAPATAN</td>
    <td align="center">Potongan</td>
    @for ($i=1; $i <=6 ; $i++)
      <td></td>
    @endfor
    <td align="center">TOTAL POTONGAN</td>
    <td align="center">THP</td>
  </tr>
  <tr align="center">
    @for ($i=0; $i <9 ; $i++)
      <td></td>
    @endfor
    @foreach ($kodeAbsen as $kode)
      <td>{{$kode}}</td>
    @endforeach
    {{-- <td></td><td></td><td></td><td></td> --}}
    <td align="center">Total</td>
    <td align="center">SA Harian</td>
    <td align="center">Total SA</td>
    <td align="center">Uang Makan Harian</td>
    <td align="center">Total Uang Makan</td>
    <td align="center">Total RIT</td>
    <td align="center">Bonus 120 RIT</td>
    <td align="center">Rp RITASE</td>
    <td align="center">Total HM</td>
    <td align="center">Rp HM</td>
    <td></td><td></td>
    <td align="center">3%</td>
    <td align="center">1%</td>
    <td align="center">Absen</td>
    <td align="center">Kasbon</td>
    <td align="center">Ijin</td>
    <td align="center">Lain-Lain</td>
    <td align="center">PPH21</td>
  </tr>
  <td>
    @php
      $no = 1 ;
    @endphp
    @forelse($karyawan as $index => $item)
      @php
          $totalTripp             = array_get($totalTrip,$item->id);
          $numNominalTrip         = number_format(array_get($nominalTrip,$item->id),2,",",".");
          $numNominalHM           = number_format(array_get($nominalHM,$item->id),2,",",".");
          $numNominalMakan        = number_format($item->uang_makan,2,",",".");
          $numNominalUangMakan    = number_format($totalUangMakan[$item->id],2,",",".");
          $numSaHarian            = number_format($item->sa_harian,2,",",".");
          $numTotalSaHarian       = number_format($totalSaHarian[$item->id],2,",",".");
          $numTigaPersen          = number_format($tigaPersen[$item->id],2,",",".");
          $numSatuPersen          = number_format($satuPersen[$item->id],2,",",".");
          $numRapel               = number_format($rapel[$item->id],2,",",".");
          $numTotalPendapatan     = number_format($totalPendapatan[$item->id],2,",",".");
          $numTotalPotonganAbsen  = number_format($totalPotonganAbsen[$item->id],2,",",".");
          $numTotalPotonganIjin   = number_format($totalPotonganIjin[$item->id],2,",",".");
          $numPph21               = number_format($pph21[$item->id],2,",",".");
          $numTotalPotongan       = number_format($totalPotongan[$item->id],2,",",".");
          $numTotalKasbon         = number_format($totalKasbon[$item->id],2,",",".");
          $numTotalLainlain       = number_format($totalLain_lain[$item->id],2,",",".");
          $numThp                 = number_format($thp[$item->id],2,",",".");
          $numProposional         = number_format($proposional[$item->id],2,",",".");
      @endphp
      <tr id="payrol_tr">
        <td class="text-center">{{ $index }}</td>
        <td>{{ $item->kode }}</td>
        <td>{{ $item->nrp}}</td>
        <td>{{ $item->biodata->nama_lengkap }}</td>
        <td align="center">{{ $item->golongan }}</td>
        <td>{{ $item->jabatan->nama}}</td>
        <td>{{ $item->departemen->nama}}</td>
        <td>Rp. {{ number_format($item->gapok,2)}}</td>
        <td>Rp. {{ $numProposional == 0?'':$numProposional }}</td>
        @foreach ($jmlAbsen as $index2 => $item2)
            <td>{{array_get($item2,$item->id)}}</td>
        @endforeach
        <td>{{array_get($totalAbsen,$item->id)}}</td>
        <td>Rp. {{$numSaHarian == 0?'-':$numSaHarian}}</td>
        <td>Rp. {{$numTotalSaHarian == 0?'-':$numTotalSaHarian}}</td>
        <td>Rp. {{$numNominalMakan == 0?'-':$numNominalMakan}}</td>
        <td>Rp. {{$numNominalUangMakan == 0?'-':$numNominalUangMakan}}</td>
        <td>{{array_get($totalTrip,$item->id)}}</td>
        <td>Rp. {{$totalTripp == 120?number_format($bonusTrip,2):'-'}}</td>
        <td>Rp. {{$numNominalTrip == 0?'-':$numNominalTrip}}</td>
        <td>{{array_get($HM,$item->id)}}</td>
        <td>Rp. {{$numNominalHM == 0?'-':$numNominalHM}}</td>
        <td>Rp. {{$numRapel == 0?'-':$numRapel}}</td>
        <td>Rp. {{$numTotalPendapatan == 0?'-':$numTotalPendapatan}}</td>
        <td>Rp. {{$numTigaPersen}}</td>
        <td>Rp. {{$numSatuPersen}}</td>
        <td>Rp. {{$numTotalPotonganAbsen == 0?'-':$numTotalPotonganAbsen}}</td>
        <td>Rp. {{$numTotalKasbon == 0?'-':$numTotalKasbon }}</td>
        <td>Rp. {{$numTotalPotonganIjin == 0?'-':$numTotalPotonganIjin}}</td>
        <td>Rp. {{$numTotalLainlain == 0?'-':$numTotalLainlain}}</td>
        <td id="payrol_td_pph21" >Rp. {{$numPph21 == 0?'-':$numPph21}}</td>
        <td>Rp. {{$numTotalPotongan == 0?'-':$numTotalPotongan}}</td>
        <td>Rp. {{$numThp == 0?'-':$numThp}}</td>
        {{-- <td class="text-center">
          <a href="{{ route('master::departemen.edit', $item->id) }}"
            class="btn btn-xs btn-outline-secondary">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{ route('master::departemen.destroy', $item->id) }}"
            data-method="DELETE" data-confirm="Anda yakin akan menghapus data ini?"
            class="btn btn-xs btn-outline-danger">
            <i class="fa fa-trash-o"></i>
          </a>
        </td> --}}
      </tr>
    @empty
      <tr>
        <td colspan="41" align="center">Tidak ada data</td>
      </tr>
    @endforelse
    <tr>
      <td colspan="7" align="center">Total</td>
      <td nowrap>Rp. {{number_format($jmlTotalGapok,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalProposional,0,",",".").',00'}}</td>
      @for ($i=1; $i <=14 ; $i++)
        <td></td>
      @endfor
      <td nowrap>Rp. {{number_format($jmlTotalSaHarian,0,",",".").',00'}}</td>
      <td></td>
      <td nowrap>Rp. {{number_format($jmlTotalUangMakan,0,",",".").',00'}}</td>
      <td></td>
      <td></td>
      <td nowrap>Rp. {{number_format($jmlTotalNominalTrip,0,",",".").',00'}}</td>
      <td></td>
      <td nowrap>Rp. {{number_format($jmlTotalNominalHM,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalRapel,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalPendapatan,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalTigaPersen,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalSatuPersen,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalAbsen,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalKasbon,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalIjin,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalLain_lain,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalPph21,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalPotongan,0,",",".").',00'}}</td>
      <td nowrap>Rp. {{number_format($jmlTotalThp,0,",",".").',00'}}</td>
    </tr>
  </td>
</html>
