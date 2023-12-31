@extends('layouts.app')

@section('content')
<!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@section('content')
<div class="container">
  @if(count($errors)>0)
  <div class="col-sm-11">
<div class="alert alert-danger">
<ul>
  @foreach($errors->all() as $error)
  <span >{{ $error }}</span><br>
  @endforeach
</ul>
</div>
</div>
@endif 
@if (session('error'))
   <div class="alert alert-danger">
        {{ session('error') }}
   </div>
@endif


  <body class="hold-transition login-page">
       
<div class="login-box">
 
  <div class="login-logo">
    <a href="#"><b>E-Procurement System</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start</p>

      <form action="{{ route('login') }}" method="POST">
         @csrf
        <div class="input-group mb-3">
        <input type="email" class="form-control" maxlength="50" placeholder="Email" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" maxlength="25" placeholder="Password"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
           @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
              @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
           
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="/password-reset" class="btn btn-block btn-primary">
        I forgot my password
        </a>
        {{-- <a href="#" class="btn btn-block btn-danger">
        Register a new membership
        </a> --}}
      </div>
      
      <!-- /.social-auth-links -->

      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</div>
@endsection
