<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	  <link rel="shortcut icon" type="image/x-icon" href="{{url('images/favicon-1.ico')}}">
	  
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>SOCRAI</title>
    <style> 
    .login-content .login-box {
    position: relative;
    min-width: 350px;
    min-height: 544px !important;
    background-color: #fff;
    -webkit-box-shadow: 0px 29px 147.5px 102.5px rgba(0, 0, 0, 0.05), 0px 29px 95px 0px rgba(0, 0, 0, 0.16);
    box-shadow: 0px 29px 147.5px 102.5px rgba(0, 0, 0, 0.05), 0px 29px 95px 0px rgba(0, 0, 0, 0.16);
    -webkit-perspective: 800px;
    perspective: 800px;
    -webkit-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
}


</style>
<script type="text/javascript">
  $(document).ready(function() {
    window.location.href = "http://www.w3schools.com";
  });
</script>
  </head>
  <body>
    <a style="display: none" id="signin" href="{{ url('login') }}">:Login</a>
    <section class="material-half-bg">
      
       
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{url('backend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('backend/js/popper.min.js')}}"></script>
    <script src="{{url('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{url('backend/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{url('backend/js/plugins/pace.min.js')}}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
      document.getElementById("signin").click();
      });
    </script>
  </body>
</html>



