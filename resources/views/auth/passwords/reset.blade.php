@extends('layouts.app')
  
@section('content')
<div class="container">

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="/">Login</a>
          </div>
        </nav>
      </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success">
                 {{ session('status') }}
            </div>
         @endif

         @if (session('error'))
            <div class="alert alert-danger">
                 {{ session('error') }}
            </div>
         @endif
            <div class="login-logo">
                <a href="#"><b>E-Procurement System</b></a>
              </div>
            <div class="card">
                <div class="card-header">{{ __('Forgot your password? No problem. Provide your email address and we send you a new password.') }}</div>

                <div class="card-body">
                    <form method="POST" id="password_reset_form" autocomplete="off" action="/password-send">
                @csrf
                   @method('PATCH') 

                        <input type="hidden" name="token" value="">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="btnSubmit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
    <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/editable-table.js"></script> 

    @if(session('status'))
    @push('scripts')
      <script>
      $(document).ready(function(){
        swal("{!! session('status') !!}", "", "success");
      });
      </script>
    @endpush
  @endif

   <script>
   $("#password_reset_form").submit(function (e) {

//stop submitting the form to see the disabled button effect
//e.preventDefault();

//disable the submit button

$("#btnSubmit").attr("disabled", true);



return true;

});

   </script>


    @endpush


