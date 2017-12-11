<table>
  <tr>
    <td>
      <div class="col-md-8 col-xs-12">
        <div class="table-wrapper">
          <table class="table table-custom table-bordered table-stripped table-sm table-absen">
            <thead>
              <tr class="table-primary" align="center">
                <th rowspan = "2">No</th>
                <th rowspan = "2">Tanggal</th>
                <th rowspan = "2">Hari</th>
                <th rowspan = "2">Status</th>
                <th colspan = "2">HM</th>
                <th colspan = "2">TRIP</th>
              </tr>
              <tr class="table-primary" align="center">
                <th>Total</th>
                <th>Insentif</th>
                <th>Total</th>
                <th>Insentif</th>
              </tr>
            </thead>
            <tbody>
              @php
                $no = 1 ;
              @endphp
              @for ($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay())
                @php
                  $kon_listNominalHM   = number_format(array_get($listNominalHM,$date->format('Y-m-d')),2,",",".");
                  $kon_listNominalTrip = number_format(array_get($listNominalTrip,$date->format('Y-m-d')),2,",",".");
                @endphp
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$date->format('Y-m-d')}}</td>
                  <td>{{trans('date.day.' . $date->format('l')) }}</td>
                  <td>{{array_get($listAbsen,$date->format('Y-m-d'))}}</td>
                  <td>{{array_get($listHM,$date->format('Y-m-d'))}}</td>
                  <td>{{$kon_listNominalHM == 0?'':$kon_listNominalHM}}</td>
                  <td>{{array_get($listTrip,$date->format('Y-m-d'))}}</td>
                  <td>{{$kon_listNominalTrip == 0?'':$kon_listNominalTrip}}</td>
                </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>
    </td>
    <td>
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
    </td>
  </tr>
  <tr>
    <td>
      <div class="table-wrapper">
        <table border='0' class="table table-bordered">
        <tr>
          <td>
            <table width="100%" border="0">
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
            <table width="100%" border="0">
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
    </td>
    <td>
      <div style="height:1270px"></div>
      <table border="1" style="text-align:center;height:45%" class="table table-custom table-bordered table-sm table-absen">
        <thead>
          <tr>
            <th>Karyawan</th>
            <th>HRD</th>
            <th>Finance</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="text-align:center;padding-top:135px"> {{$karyawan->biodata->nama_lengkap}}</td>
            <td ><img src="{{ $karyawan->foto_url }}" width="150"></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</table>
