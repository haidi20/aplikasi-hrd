@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Waktu-Hauling
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{ route('waktu-hauling.index',['hauling_id' => session()->get('hauling_id')]) }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <form action="{{ $action }}" method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="jam">Jam</label>
                <input type="text" name="jam" id="jam" value="{{old('jam')}}" class="form-control jam {{is_invalid($errors,'jam')}}">
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="tonase">Tonase</label>
                <input type="text" name="tonase" id="tonase" value="{{old('tonase')}}" class="form-control {{is_invalid($errors,'tonase')}}">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-10"></div>
              <div class="col-md-2">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <hr class="dashed">
    @include('waktu.table')
  </div>
@endsection
