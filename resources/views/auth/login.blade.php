<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	  <!-- <link rel="shortcut icon" type="image/x-icon" href="{{url('images/favicon-1.ico')}}"> -->
	  <link rel="icon" href="{{ url('frontend/images/favicon.png')}}" type="image/png">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Socrai | Login</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <?php /*?><h1>VEDI</h1><?php */?>
        <a class="app-header__logo" href="" style="background: none; font-size: 40px;"><img src="{{asset('sucrai/assets/images/logo.png')}}" alt="" width="200">  </a>

      </div>
      <div class="login-box">

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
		 <form class="login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i> SIGN IN </h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
             <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
			   @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
           <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">

               <!-- <p class="semibold-text mb-2"><a href="{{url('register')}}"> Register Now </a></p> -->

              </div>
              <!-- <p class="semibold-text mb-2"><a href="javascript:void(0);" data-toggle="flip">Forgot Password ?</a></p> -->
            </div>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>

        <form class="forget-form" action="index.html">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>

        </form>
      </div>
   <!--    <div class="row">
         <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
              <a href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
              <a href="{{url('/redirect_google')}}" class="btn btn-primary">Login with Google</a>
            </div>
        </div>
      </div> -->
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{url('public/backend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('public/backend/js/popper.min.js')}}"></script>
    <script src="{{url('public/backend/js/bootstrap.min.js')}}"></script>
    <script src="{{url('public/backend/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{url('public/backend/js/plugins/pace.min.js')}}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>


