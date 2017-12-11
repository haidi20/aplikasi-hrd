  <div class="table-wrapper">
  <table border='2' class="table table-custom table-bordered table-sm table-absen">
  <br><br><br>
  <tr>
    <td>
      <table width="100%">
        <tr>
          <td>Gaji Pokok</td>
          <td>Rp.{{number_format($karyawan->gapok,2,",",".")}}</td>
        </tr>
        <tr>
          <td>Pendapatan</td>
          <td></td>
        </tr>
        <tr>
          <td>Total Trip</td>
          <td>{{array_get($trip,$karyawan->id) == 0?0:array_get($trip,$karyawan->id)}}</td>
        </tr>
        <tr>
          <td>Insentif Trip</td>
          <td>Rp.{{number_format(array_get($nominalTrip,$karyawan->id),2,",",".")}}</td>
        </tr>
        <tr>
          <td>Total HM</td>
          <td>{{array_get($HM,$karyawan->id) == 0?0:array_get($HM,$karyawan->id)}}</td>
        </tr>
        <tr>
          <td>Insentif HM</td>
          <td>Rp.{{number_format(array_get($nominalHM,$karyawan->id),2,",",".")}}</td>
        </tr>
        <tr>
          <td>Uang Makan</td>
          <td>Rp.{{number_format($karyawan->uang_makan,2,",",".")}}</td>
        </tr>
        <tr>
          <td>Total Upah Kotor</td>
          <td>Rp.{{number_format($totalPendapatan,2,",",".")}}</td>
        </tr>
      </table>
      <br>
      <table width="100%">
        <tr>
          <td>Potongan-potongan</td>
          <td></td>
        </tr>
        <tr>
          <td>Pot. Absensi</td>
          <td>Rp. {{$totalPotonganAbsen == 0?'-':number_format($totalPotonganAbsen,2,",",".")}}</td>
        </tr>
        <tr>
          <td>Pot. Izin Tidak Resmi</td>
          <td>Rp. {{$totalNominalI == 0 ?'-':number_format($totalNominalI,2,",",".")}}</td>
        </tr>
        <tr>
          <td>Pot. BPJS-TK</td>
          <td>Rp. {{$karyawan->bpjs_tk == 0?'-':number_format($karyawan->bpjs_tk,2,",",".")}}</td>
        </tr>
        <tr>
          <td>Pot. BPJS-Kes</td>
          <td>Rp. {{$karyawan->bpjs_kes == 0?'-':number_format($karyawan->bpjs_kes,2,",",".")}}</td>
        </tr>
        <tr>
          <td>Pot. Lain-lain</td>
          <td>Rp. {{$totalLain_lain == 0?'-':number_format($totalLain_lain,2,",",".")}}</td>
        </tr>
        @if (!$hidePPH21)
          <tr id="slip_tr_pph21">
            <td>PPH 21</td>
            <td>Rp. {{$pph21 == 0?'-':number_format($pph21,2,",",".")}}</td>
          </tr>
        @endif
        <tr>
          <td>Total Potongan</td>
          <td>Rp. {{$totalPotongan == 0?'-':number_format($totalPotongan,2,",",".")}}</td>
        </tr>
      </table>
      <br>
      <table width="100%">
        <tr>
          <td>Upah Bersih yang dibayarkan</td>
          <td>Rp. {{$upahBersih == 0?'-':number_format($upahBersih,2,",",".")}}</td>
        </tr>
      </table>
      <br>
      <table width="100%">
        <tr>
          <td>Terbilang: <br> <p style="font-size:20px">{{$terbilang}}</p></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>
