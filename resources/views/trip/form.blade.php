@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title p0 m0">
          Form Trip
        </h2>
      </div>
      <div class="col-md-6 text-right">
        {{-- <a href="{{ route('master::departemen.index') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a> --}}
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <form action="{{ $action }}" method="post">
          <input type="hidden" name="_method" value="{{ $method }}">
          {{ csrf_field() }}
          @if (Session::get('note'))
            <div class="alert alert-success">
              {{Session::get('note')}}
            </div>
          @endif
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="biasa">Anggaran Trip 1 - 4</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'biasa') }}" name="biasa" id="biasa" value="{{ old('biasa') }}">
                {!! show_inline_error($errors, 'biasa') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="lumayan">Anggaran Trip 5 dan seterusnya</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'lumayan') }}" name="lumayan" id="lumayan" value="{{ old('lumayan') }}">
                {!! show_inline_error($errors, 'lumayan') !!}
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="bonus">Bonus Anggaran Jumlah Trip 120</label>
                <input type="text" class="form-control {{ is_invalid($errors, 'bonus') }}" name="bonus" id="bonus" value="{{ old('bonus') }}">
                {!! show_inline_error($errors, 'bonus') !!}
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
  </div>
@endsection
