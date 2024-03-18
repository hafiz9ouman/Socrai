@extends( 'admin.layouts.app' )

@section( 'content' )
	<div class="app-title">

		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
			</li>
			<li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
			</li>
			<li class="breadcrumb-item"><a href="{{url('/users')}}">All Users</a>
			</li>
			<li class="breadcrumb-item">Change Password</li>
		</ul>
	</div>
<div class="row">
	<div class="col-md-12">

<?php 
if (count($errors) > 0){
	

?>
	<ul>
                    @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>

	<?php
}

?>
			@if(session()->has('error'))
			    <div class="alert alert-danger">
			        {{ session()->get('error') }}
			    </div>
			@endif
			@if(session()->has('alert'))
			    <div class="alert alert-alert">
			        {{ session()->get('alert') }}
			    </div>
			@endif

			

			  @if (session('success'))
            <div class="alert  alert-info" style="width: 100%">
                {{ session('success') }}
            </div>
            @endif
            @if (session('Failed'))
            <div class="alert alert-danger" style="width: 100%">
                {{ session('Failed') }}
            </div>
            @endif
            


			<div class="tile">
				<h3 class="tile-title">Update Password</h3>
				<form class="form-horizontal" method="POST" action="/update-password-post" oninput='confirm_password.setCustomValidity(confirm_password.value != password.value ? "Passwords do not match." : "")'>
					{{ csrf_field() }}
                    
					<div class="row">
						  

						
						
				


						<div class="col-sm-6 col-md-4 ">
                            <label for="comp"> Password</label>
                            
                            <input id="password"  type="text" class="form-control " name="password"   value=""  minlength='8'  required >

                        </div>

						<div class="col-sm-6 col-md-4 ">
                            <label for="comp">Confirm Password</label>
                            
                            <input id="confirm_password"  type="text" class="form-control " name="confirm_password" value="" required >

                        </div>

										
						
						

					<input id="file" type="hidden" class="form-control" name="id" value="{{$user->id}}">

                    </div>
                    @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{url('site_admin')}}" class="btn btn-primary">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-success">@lang('general.save')</button>
                        </div>
                    @endif
				</form>

			</div>

	</div>
</div>

@endsection


				
				
