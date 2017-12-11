@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>
          Hauling-Trip
        </h3>
      </div>
      @if (Auth::user()->username == 'admin')
        <div class="col-md-6 text-right">
          <a href="{{ route('hauling.create') }}" class="btn btn-primary btn-md"><i class="fa fa-plus-circle"></i> Tambah</a>
        </div>
      @endif
    </div>
    <hr class="dashed mt20 mb20">
    <form action="{{route('hauling.index')}}" method="get">
    <div class="row">
      <div class="col-md-8"></div>
      <div class="col-md-2">
        <label for="departemen" style="font-size:20px">Departemen</label>
        <select name="departemen" id="departemen" class="form-control {{is_invalid($errors,'departemen')}}">
          <option value="">Semua Departemen</option>
          @foreach ($departemen as $index => $item)
            <option value="{{$item->id}}" {{$item->id == request('departemen') ? 'selected':''}}>{{$item->nama}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2" style="padding-top:35px">
        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-filter fa-fw"></i> Filter</button>
      </div>
    </div>
    </form>
    <br>
    @include('hauling.table')
  </div>
@endsection
