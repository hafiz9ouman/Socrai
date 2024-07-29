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
			<li class="breadcrumb-item">Edit Admin</li>
		</ul>
	</div>
<div class="row">
	<div class="col-md-12">


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
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


			<div class="tile">
				<h3 class="tile-title">Edit User</h3>
				<form class="form-horizontal" method="POST" action="{{ url('/site_admin/update') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						   <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input  id="image"  type="file" placeholder="image" value="{{$user->image}}" class="form-control" name="image">
                            </div>
                        </div>

						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-control-label">Name</label>
								<input id="name" type="text" class="form-control " name="name" value="{{ $user->name }}"  autofocus>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Email</label>
								<input id="email"  type="email" class="form-control " name="email" value="{{ $user->email }}"  >
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Password</label>
								<input id="password"  type="password" class="form-control " name="password"  >
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Confirm Password</label>
								<input id="cpassword"  type="password" class="form-control " name="cpassword"  >
							</div>
						</div>
						
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								
								
								<label for="comp">2FA</label>
                                <select name="tfa" class="form-control "  required >
                                    <option <?php if($user->tfa==1) { echo 'selected'; } ?> value="1">Yes</option>
									<option <?php if($user->tfa==0) { echo 'selected'; } ?> value="0">No</option>
                                </select>
																	
																	
							</div>
						</div>
				


                       
						
						
		

		
	@php
	$user_id = Request::segment(3);
	@endphp
	@if( twoFactorExists($user_id) )
	<div class="col-sm-6 col-md-4">
	<div class="form-group">
		<a href="{{ url('/2fa/disable/' . $user_id ) }}" class="btn btn-xs btn-info pull-right">Disable 2FA</a>
	</div>
	</div>
	@endif
						
						
						

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


