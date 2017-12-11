@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-right">
        <form action="{{route('payrol.index')}}" method="get">
          <div class="row">
            <div class="col-md-1">
              <h3>
                Payroll
              </h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label for="kode" class="col-form-label" style="font-size:20px"> Kode</label>
              <select name="kode" id="kode" class="form-control custom-select" >
                <option value="">Semua Kode</option>
                @foreach ($kodeAll as $index => $item)
                  <option value="{{$item->kode}}" {{$item->kode == request('kode')? 'selected':''}}>{{$item->kode}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="namaFind" class="col-form-label" style="font-size:20px"> Nama Karyawan</label>
              <select name="namaFind" id="namaFind" class="form-control custom-select" >
                <option value="">Semua Nama</option>
                @foreach ($karyawanAll_B as $index => $item)
                  @if ($item->biodata)
                    <option value="{{$item->id}}" {{request('namaFind') == $item->id?'selected':''}}>{{$item->biodata->nama_lengkap}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="jabatan" class="col-form-label" style="font-size:20px"> Jabatan</label>
              <select name="jabatan" id="jabatan" class="form-control custom-select">
                <option value="">Semua Jabatan</option>
                @foreach ($jabatanAll as $index => $item)
                  <option value="{{$item->id}}" {{$item->id == request('jabatan')?'selected':''}}>{{$item->nama}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="departemen" class="col-form-label" style="font-size:20px">Departemen</label>
              <select name="departemen" id="departemen" class="form-control custom-select">
                <option value="">Semua Departemen</option>
                @foreach ($departemenAll as $index => $item)
                  <option value="{{$item->id}}" {{$item->id == request('departemen')?'selected':''}}>{{$item->nama}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="bulan" class="col-form-label" style="font-size:20px">Bulan</label>
              <select class="form-control  custom-select" id="bulan" name="bulan">
                @foreach($listBulan as $index => $bulan)
                  <option value="{{ $index + 1 }}" {{ (request('bulan', date('n'))-1) ==  $index ? 'selected' : '' }}>{{ $bulan }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="tahun" class="col-form-label" style="font-size:20px">Tahun </label>
              <select class="form-control  custom-select" id="tahun" name="tahun" >
                @for ($tahun = $tahunSekarang->copy(); $tahun->diffInYears($tahunAwal) ; $tahun->subYear())
                  <option value="{{$tahun->format('Y')}}" {{request('tahun')==$tahun->format('Y')?'selected':''}}>{{$tahun->format('Y')}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" style="margin-top:33px; max-width:none;"><i class="fa fa-filter fa-fw"></i> Filter</button>
              </div>
            </div>
          </div>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="col-md-12 text-right">
      <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-2">
          <button type="submit" name="tambahan" value="tambahan" class="btn btn-success btn-block btn-md"><i class="fa fa-plus"></i> Tambahan</button>
        </div>
        <div class="col-md-2">
          <button type="submit" name="potongan" value="potongan" class="btn btn-warning btn-block btn-md"><i class="fa fa-puzzle-piece"></i> Potongan</button>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <button type="submit" name="rekap" value="rekap" class="btn btn-primary btn-block btn-md rekap"><i class="fa fa-file-code-o"></i> Rekap</button>
          </div>
        </div>

        <div class="col-md-2">
          <a href="?hide-pph21={{ $hidePPH21 ? 'false' : 'true' }}&tahun={{request('tahun')}}&bulan={{request('bulan')}}&departemen={{request('departemen')}}&jabatan={{request('jabatan')}}&nama={{request('namaFind')}}&kode={{request('kode')}}"
            class="btn btn-danger btn-block btn-md">{{ $hidePPH21 ? 'Munculkan' : 'Hilangkan' }} PPH21
          </a>
            {{-- <button type="sumbit" nama="hide-pph21" value="{{ $hidePPH21 ? 'false' : 'true' }}" class="btn btn-danger btn-block btn-md">{{ $hidePPH21 ? 'Munculkan' : 'Hilangkan' }} PPH21</button> --}}
        </div>
        </form>
      </div>
    </div>
    <div class="col-md-12" style="overflow:scroll;max-width:100%;">
      <table class="table table-bordered table-custom table-striped table-sm">
      <thead>
        <tr class="table-primary">
          <th rowspan = "2" class="text-center mar" width="30">No</th>
          <th rowspan = "2" class="text-center mar">Kode</th>
          <th rowspan = "2" class="text-center mar">NRP</th>
          <th rowspan = "2" class="text-center mar">Nama Karyawan</th>
          <th rowspan = "2" class="text-center mar">GOL</th>
          <th rowspan = "2" class="text-center mar">Jabatan</th>
          <th rowspan = "2" class="text-center mar">Departemen</th>
          <th rowspan = "2" class="text-center mar">Gaji Pokok</th>
          <th rowspan = "2" class="text-center mar">Gaji Proposional</th>
          <th colspan = {{count($kodeAbsen) + 1}} class="text-center">Absensi</th>
          <th class="text-center" colspan='4'>Pendapatan Tidak Tetap</th>
          <th class="text-center" colspan='5'>Produksi</th>
          <th rowspan = "2" class="text-center mar">Rapel / Lain-lain</th>
          <th rowspan = "2" class="text-center mar">TOTAL PENDAPATAN</th>
          <th colspan = "{{ $hidePPH21 ? 6 : 7 }}" class="text-center" id="payrol_th_potongan">Potongan</th>
          <th rowspan="2" class="text-center mar">TOTAL POTONGAN</th>
          <th rowspan="2" class="text-center mar">THP</th>
          {{-- <th rowspan="2" class="text-center mar">Action</th> --}}
        </tr>
        <tr class="table-primary" style="text-align:center">
          @foreach ($kodeAbsen as $kode)
            <th>{{$kode}}</th>
          @endforeach
            <th>Total</th>
            <th>SA Harian</th>
            <th>Total SA</th>
            <th>Uang Makan Harian</th>
            <th>Total Uang Makan</th>
            <th>Total RIT</th>
            <th>Bonus 120 RIT</th>
            <th>Rp RITASE</th>
            <th>Total HM</th>
            <th>Rp HM</th>
            <th>3%</th>
            <th>1%</th>
            <th>Absen</th>
            <th>Kasbon</th>
            <th>Ijin</th>
            <th nowrap>Lain-Lain</th>
            @if(!$hidePPH21)
            <th>PPH21</th>
            @endif
        </tr>
      </thead>
      <tbody id="payrol_body">
        @forelse($karyawan as $index => $item)
          @if ($item->biodata && $item->jabatan && $item->departemen)
            @php
                if ($karyawan->currentPage() >= 1) {
                    $no = (($karyawan->currentPage() * 10) - 10) + $index + 1 ;
                }
                $totalTripp             = array_get($totalTrip,$item->id);
                $numNominalTrip         = number_format(array_get($totalNominalTrip,$item->id),2,",",".");
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
              <td class="text-center mar">{{ $no }}</td>
              <td nowrap>{{ $item->kode }}</td>
              <td nowrap>{{ $item->nrp}}</td>
              <td nowrap>{{ $item->biodata->nama_lengkap }}</td>
              <td align="center" nowrap>{{ $item->golongan }}</td>
              <td nowrap>{{ $item->jabatan->nama}}</td>
              <td nowrap>{{ $item->departemen->nama}}</td>
              <td nowrap>Rp. {{ number_format($item->gapok,2)}}</td>
              <td nowrap>Rp. {{ $numProposional }}</td>
              @foreach ($jmlAbsen as $index2 => $item2)
                  <td>{{array_get($item2,$item->id)}}</td>
              @endforeach
              <td>{{array_get($totalAbsen,$item->id)}}</td>
              <td nowrap>Rp. {{$numSaHarian == 0?'-':$numSaHarian}}</td>
              <td nowrap>Rp. {{$numTotalSaHarian == 0?'-':$numTotalSaHarian}}</td>
              <td nowrap>Rp. {{$numNominalMakan == 0?'-':$numNominalMakan}}</td>
              <td nowrap>Rp. {{$numNominalUangMakan == 0?'-':$numNominalUangMakan}}</td>
              <td>{{array_get($jmlTrip,$item->id)}}</td>
              <td nowrap>Rp. {{array_get($jmlTrip,$item->id) >= 120?number_format($bonusTrip,2):'-'}}</td>
              <td nowrap>Rp. {{$numNominalTrip == 0?'-':$numNominalTrip}}</td>
              <td>{{array_get($HM,$item->id)}}</td>
              <td nowrap>Rp. {{$numNominalHM == 0?'-':$numNominalHM}}</td>
              <td nowrap>Rp. {{$numRapel == 0?'-':$numRapel}}</td>
              <td nowrap>Rp. {{$numTotalPendapatan == 0?'-':$numTotalPendapatan}}</td>
              <td nowrap>Rp. {{$numTigaPersen}}</td>
              <td nowrap>Rp. {{$numSatuPersen}}</td>
              <td nowrap>Rp. {{$numTotalPotonganAbsen == 0?'-':$numTotalPotonganAbsen}}</td>
              <td nowrap>Rp. {{$numTotalKasbon == 0?'-':$numTotalKasbon }}</td>
              <td nowrap>Rp. {{$numTotalPotonganIjin == 0?'-':$numTotalPotonganIjin}}</td>
              <td nowrap>Rp. {{$numTotalLainlain == 0?'-':$numTotalLainlain}}</td>
              @if(!$hidePPH21)
              <td nowrap id="payrol_td_pph21" >Rp. {{$numPph21 == 0?'-':$numPph21}}</td>
              @endif
              <td nowrap>Rp. {{$numTotalPotongan == 0?'-':$numTotalPotongan}}</td>
              <td nowrap>Rp. {{$numThp == 0?'-':$numThp}}</td>
            </tr>
          @endif
        @empty
          <tr>
            <td colspan="{{$hidePPH21?41:42}}" align="center">Tidak ada data</td>
          </tr>
        @endforelse
        {{-- @if ($karyawan->currentPage() == $karyawan->lastPage()) --}}
          <tr>
            <td colspan="7" align="center">Total</td>
            <td nowrap>Rp. {{number_format($jmlTotalGapok,0,",",".").',00'}}</td>
            <td nowrap>Rp. {{number_format($jmlTotalProposional,0,",",".").',00'}}</td>
            @php $maks = $hidePPH21?13:14; @endphp
            @for ($i=1; $i <=$maks ; $i++)
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
        {{-- @endif --}}
      </tbody>
    </table>
    </div>
    {!! $karyawan->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
  </div>
@endsection
