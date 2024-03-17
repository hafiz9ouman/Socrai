@extends( 'admin.layouts.app' )
@section( 'content' )
 
    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Tribes Joined by Tribe Leader</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
               
               @foreach($leader_in_tribes as $row)
				<p>
				
				<a href="{{url('/tribemembers/' . $row->id)}}" class="btn btn-sm btn-info center">{{ $row->title }}</a>
				
				
				</p>
			   @endforeach
			   
			   
			   
                    
                </div>
            </div>
    </div>
   




@endsection
