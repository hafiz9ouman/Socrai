<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel='icon' href="{{url('frontend/images/16x16.png')}}" type='image/x-icon' sizes="48x48">
    <!-- <link rel="icon" href="{{ url('frontend/images/16x16.png')}}" type="image/png" size="50/16"> -->
     <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="{{url('backend/css/sweetalert.css')}}">
     <link rel="stylesheet" type="text/css" href="{{url('frontend/css/jquery.countdown.css')}}">
    <link href="{{ url('frontend/css/slick.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('frontend/css/jquery.lineProgressbar.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('frontend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ url('frontend/js/jquery-2.2.3.min.js') }}"></script>

    <script type="text/javascript" src="{{ url('frontend/video/jquery.vide.js') }}"></script>

     <!--<script type="text/javascript" src="{{ url('frontend/video/jquery.vide.js') }}"></script>-->

    <script src="{{url('backend/js/sweetalert.js')}}"></script>
    <style>
      @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
      }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }


    </style>
    
   
    </head>
   <body>
       <header>
         <div class="header">
          <div class="container">
            <div class="header-body">
              <div class="logo">
                <a href="{{ url('/') }}">
                <img class="img-fluid" src="{{ url('frontend/images/logo.png')}}">
                </a>
              </div>
            </div>
          </div>
         </div>
 
 
 
           
       </header>
    <!-- header-->
    <main class="app-content">
      @yield('content')
    </main>
    <script src="{{url('frontend/js/jquery.countdown.min.js')}}"></script>

  </body>
</html>

