<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
=======

<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('general.site_title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{url('backend/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{url('backend/css/fontastic.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{url('backend/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{url('backend/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{url('backend/img/logo-vedi.png')}}">
  
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
      
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex justify-content-center align-items-center">
                <div class="content">
                  <div class="logo text-center">
					  <img src="{{url('backend/img/logo-vedi.png')}}" alt="" width="150" class="mb-3">
                    <h1>@lang('passwords.reset_password')</h1>
                  </div>
                  <p></p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                 @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
<<<<<<< HEAD
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
=======
                            <label for="email" >@lang('login.email')</label>

                                <input autofocus id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
<<<<<<< HEAD
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
=======
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" >@lang('passwords.password')</label>

>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
<<<<<<< HEAD
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
=======
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" >@lang('passwords.confirm_password')</label>
>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
<<<<<<< HEAD
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
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
=======
                        </div>

                        <div class="form-group">
                        	<a href="{{ url('login')}}" class="forgot-pass mt-2">@lang('login.login')</a>
                                <button type="submit" class="btn btn-primary float-right">
                                  @lang('passwords.reset_password')
                                </button>
                        </div>
                    </form>
				
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </div>
  
  </body>
</html>







>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c
