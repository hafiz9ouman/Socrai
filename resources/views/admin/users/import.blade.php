@extends( 'admin.layouts.app' )
@section( 'content' )

<div class="app-title">

<div>
	<h1><i class="fa fa-edit"></i> Users Import</h1>
		<p>User can download sample import and can import users</p>
	</div>	

	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a>
		</li>
	</ul>
</div>


<script>



</script>
<div class="row">
        <div class="col-md-6">

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if ( Session::get('success') )
				<div class="alert alert-success">
					<ul>
						
							<li>{{ Session::get('success') }}</li>
						
					</ul>
				</div>
			@endif
			       <?php    $error_mess = explode(';',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   


                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
							    {!! $errmess !!}  
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							  </button>
							</div>
                                  
                           <!--      <div class="alert alert-danger" style="width: 100%"> 
                                            {!! $errmess !!}  
                                        </div> -->

                             <?php
                  }
              }

         ?>


          <div class="tile">
            <h3 class="tile-title">Import Users</h3>
            <div class="tile-body">
              <form action="{{ route( 'import_users' )  }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
			  	<input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                  <label class="control-label">Upload</label>
                  <input class="form-control" type="file" name="file">
				</div>
				
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit">
				  <i class="fa fa-fw fa-lg fa-check-circle"></i>Import</button>
				  &nbsp;&nbsp;&nbsp;
				  <a class="btn btn-secondary" href="{{ url('/users') }}">
					  <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
					  &nbsp;&nbsp;&nbsp;
				  <a class="btn btn-secondary" href="{{ url('/users/csv/sample') }}">
					  <i class="fa fa-fw fa-lg fa-times-circle"></i>Download Sample</a>
			</div>
			
			</form>
          </div>
        </div>
      
        <div class="clearix"></div>
        
      </div>

@endsection