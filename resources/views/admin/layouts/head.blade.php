<head>
    <title>Admin @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('backend/css/sweetalert.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('backend/css/custom.css')}}">
	<script src="{{asset('backend/js/jquery-3.2.1.min.js')}}"></script>
    <?php /*?><script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script><?php */?>
	<script src="{{asset('backend/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{asset('backend/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	{{-- <script src="{{asset('backend/js/sweetalert.js')}}"></script> --}}
	<style type="text/css">
		.note-popover {
			display: none;
		}
        table td{
            text-transform: none !important;
        }
	</style>
  </head>