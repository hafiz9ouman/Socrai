@extends( 'admin.layouts.app' )
@section( 'content' )

<div class="app-title">

<div>
	<h1><i class="fa fa-edit"></i> Media Import</h1>
		<p>Media can me video or images including different types (mp4, jpg, png are supported)</p>
	</div>	

	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a>
		</li>
	</ul>
</div>

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


          <div class="tile">
            <h3 class="tile-title">Import Media</h3>
            <div class="tile-body">
              <form action="{{ route( 'store.media' )  }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
			  	<input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                  <label class="control-label">Upload</label>
                  <input class="form-control" type="file" name="file[]" multiple="true">
				</div>
				 <div class="form-group ">
                            <label for="comp">Topic</label>
                            <select name="topic" class="form-control " required>
                                <option value="">--Select Topic--</option>
                                @foreach ($topic as $xc)
                                <option value="{{ $xc->id }}" >{{ $xc->title }}</option>
                                @endforeach
                            </select>
                        </div>
			
				
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit">
				  <i class="fa fa-fw fa-lg fa-check-circle"></i>Import</button>
				  &nbsp;&nbsp;&nbsp;
				  <a class="btn btn-secondary" href="{{ url('/media/home') }}">
					  <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
					  &nbsp;&nbsp;&nbsp;
				  
			</div>
			
			</form>
          </div>
        </div>
      
        <div class="clearix"></div>
        
      </div>

@endsection