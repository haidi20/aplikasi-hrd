@extends('_layout.basic')

@section('basic-content')
  <div class="login-wrapper d-flex justify-content-center">
    <div class="container align-self-center" style="min-height: 350px;">
        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <h2 class="text-center">Aplikasi HRD PT. SMP</h2>
                <hr class="dashed">
                {!! show_bs_message($errors->all(), 'danger') !!}
                <div class="card card-primary">
                    <h4 class="card-header text-center bg-primary text-white">
                        Login
                    </h4>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-fw fa-user"></i></div>
                                  <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-fw fa-lock"></i></div>
                                  <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-send"></i> Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
