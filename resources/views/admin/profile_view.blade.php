@extends( 'admin.layouts.app' )
@section('content')
<style>
.not-fount > h1 {
    color: red;
    padding: 3% 0%;
    border: 1px solid;
}
</style>
 <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            
            <li class="breadcrumb-item">Edit Profile</li>
        </ul>
    </div>
	
	
 <div class="row">
        <div class="col-md-12">
		
		<div class="tile">
		
          <div class="right_section">
		  
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

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

            <div>
              <h3>Edit Profile</h3>
            </div>
            <form action="{{ url('/profile/update/'. $user->id)  }}" method="POST">
			{{ csrf_field() }}


			  <div class="row">
              <div class="col-md-12">
                <div class="form-group">
				 <label> Name</label>
                  <input type="text" name="name" value="{{$user->name}}" class="form-control">
                 
                </div>
                <div class="form-group">
				 <label>City</label>
                  <input type="text" name="city" value="{{$user->city}}" class="form-control">
                 
                </div>
              </div>
            </div>
			
			
			
           <div class="form-group">
				<label>Country</label>
              <input type="text"  name="country" value="{{$user->country}}" class="form-control">
              
            </div>
			
			
            <div class="form-group">
				<label>Email</label>
              <input type="email"  name="email" value="{{$user->email}}" class="form-control">
              
            </div>
          
			<div class="form-group">
				<label>Password</label>
				<input type="password"  name="password" value="" class="form-control" autocomplete="off">
              
            </div>
				<div class="form-group">
				<label>Confirm Password</label>
				<input type="password"  name="rpassword" value="" class="form-control" autocomplete="off">
              
            </div>
            
            <div class="confirm_btn">
              <button type="submit" class="btn">Update</button>
            </div>
          </form>
        </div>
      </div>
   </div>
 </div>

@endsection()

