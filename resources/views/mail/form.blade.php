@extends('_layout.default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="page-title">
          Form Pengaturan Email
        </h2>
      </div>
      <div class="col-md-6 text-right">
        <a href="{{route('setemail.index')}}" class="btn btn-primary btn-sm">
          <i class="fa fa-reply"></i> Kembali
        </a>
      </div>
    </div>
    <hr class="dashed mt20 mb20">
    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <form action="{{$action}}" method="post">
          <input type="hidden" name="_method" value="{{$method}}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="text" name="email" id="email" class="form-control {{is_invalid($errors,'email')}}" value="{{old('email')}}">
                {!! show_inline_error($errors,'email') !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md text-right">
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-md">
                  <i class="fa fa-save fa-fw"></i> Simpan
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    @include('mail.table')
  </div>
@endsection
