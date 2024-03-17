<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
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
>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
<<<<<<< HEAD

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
=======
                     <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">

                            <!-- <label for="email" class="label-material">@lang('login.email')</label> -->
                           
                                <input id="email" type="email" placeholder="@lang('login.email')" class="form-control" name="email" value="{{ old('email') }}" required>
>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
<<<<<<< HEAD
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
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
                                <button type="submit" class="btn btn-success float-right">
                                    @lang('passwords.reset_password_link')
                                </button>
                        </div>
                    </form>
				
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
       
      </div>
    </div>
  
  </body>
</html>






>>>>>>> d1065cafa3326b404e13da599e15c4ea3118528c
