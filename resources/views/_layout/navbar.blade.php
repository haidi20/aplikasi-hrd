<nav class="navbar navbar-expand-lg navbar-light mb20" style="background-color: #000080; border-bottom: 1px solid #91d3ff; height:90px">
  {{-- style="background-color: #000080; border-bottom: 1px solid #91d3ff;" --}}
  <div class="container">
    <a class="navbar-brand" style="color:white;font-size:18px" href="#"><i class="fa fa-users"></i> HRD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'pemberitahuan'?'background-color:#00B0F0':''}}">
          <a class="nav-link" style="color:white;font-size:18px" href="{{route('pemberitahuan.index')}}"><i class="fa fa-tachometer"></i> Dashboard <span class="sr-only">(current)</span></a>
        </li>
        @if (Auth::check() && Auth::user()->username =='admin')
          <li class="nav-item dropdown atas" style="height:80px; padding-top:17px; {{session()->get('warna') == 'master'?'background-color:#00B0F0':''}}">
            <a class="nav-link dropdown-toggle" style="color:white;font-size:18px" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-cubes"></i> Master
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item {{session()->get('pilihan') == 'departemen'?'active':''}}" href="{{ route('master::departemen.index') }}">Departemen</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'jabatan'?'active':''}}" href="{{ route('master::jabatan.index')}}">Jabatan</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'biodata'?'active':''}}" href="{{ route('master::biodata.index')}}">Biodata</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'site'?'active':''}}" href="{{ route('master::site.index')}}">Site</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'karyawan'?'active':''}}" href="{{ route('master::karyawan.index')}}">Karyawan</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'alat'?'active':''}}" href="{{ route('master::alat.index')}}">Alat</a>
            </div>
          </li>
        @endif
        <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'absen'?'background-color:#00B0F0':''}}">
          <a class="nav-link" style="color:white;font-size:18px" href="{{ route('absen.index')}}"><i class="fa fa-address-book"></i> Absen</a>
        </li>
        @if (Auth::check() && Auth::user()->username =='admin')
          <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'hauling'?'background-color:#00B0F0':''}}">
            <a class="nav-link" style="color:white;font-size:18px" href="{{ route('hauling.index')}}"><i class="fa fa-bar-chart"></i> Hauling</a>
          </li>
          <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'hour'?'background-color:#00B0F0':''}}">
            <a class="nav-link" style="color:white;font-size:18px" href="{{ route('hour.index')}}"><i class="fa fa-bar-chart"></i> Hour</a>
          </li>
          <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'trip'?'background-color:#00B0F0':''}}">
            <a class="nav-link" style="color:white;font-size:18px" href="{{ route('trip.index')}}"><i class="fa fa-truck"></i> Trip</a>
          </li>
          <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'meter'?'background-color:#00B0F0':''}}">
            <a class="nav-link" style="color:white;font-size:18px" href="{{ route('meter.index')}}"><i class="fa fa-wrench"></i> HM Alat</a>
          </li>
        @endif
        <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'payroll'?'background-color:#00B0F0':''}}">
          <a class="nav-link" style="color:white;font-size:18px" href="{{ route('payrol.index')}}"><i class="fa fa-money"></i> Payroll</a>
        </li>
        <li class="nav-item" style="height:80px; padding-top:17px; {{session()->get('warna') == 'slip'?'background-color:#00B0F0':''}}">
          <a class="nav-link" style="color:white;font-size:18px" href="{{ route('slip.index')}}"><i class="fa fa-vcard"></i> Slip</a>
        </li>
      </ul>

      {{-- @if (Auth::user()->username =='admin') --}}

      <ul class="navbar-nav navbar-right mr-auto ml-auto ">
        <li class="nav-item dropdown" >
          <a class="nav-link dropdown-toggle" style="color:white;font-size:18px;margin-left:40px; " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog fa-fw"></i> Pengaturan
          </a>
          <div class="dropdown-menu">
            @if (Auth::check() && Auth::user()->username =='admin')
              <a class="dropdown-item {{session()->get('pilihan') == 'pengaturan'?'active':''}}" href="{{ route('pengaturan.index')}}">Pengaturan Rumus</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'setabsen'?'active':''}}" href="{{ route('setabsen.index')}}">Pengaturan Nominal Absen</a>
              <a class="dropdown-item {{session()->get('pilihan') == 'setemail'?'active':''}}" href="{{ route('setemail.index')}}">Pengaturan Email</a>
            @endif
            <a class="dropdown-item" href="{{url('/logout')}}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" style="color: black">
                    Logout
            </a>

            <form id="logout-form" action="{{url('/logout')}}" method="POST" >
                {{ csrf_field() }}
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
