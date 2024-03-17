@extends( 'admin.layouts.app' )

@section( 'content' )
    <div class="app-title">
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
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{route('tribes')}}">All Tribes</a>
            </li>
            <li class="breadcrumb-item">Add Topic</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile container">
                <h3 class="tile-title">Add Topic</h3>
                <form class="form-horizontal" method="POST" action="/tribe_topic_store" enctype="multipart/form-data">
                         {{ csrf_field() }}
                    <div class="row">


                
                        <div class="w-100">
                            <!-- <label for="comp">Topics</label> -->
                            @if(!isset($topics) || !(count($topics)) )
                                <div class=" text-center"> 
                                        <img src="{{ url('/public/images/sucrai/warning.jpg') }}" style="width: 25%;" class="text-center">

                                        <h5 class="text-center">There are no topic available right now!</h5>
                                        <a href="{{ url('topics/add') }}" class="btn  btn-warning"> <i class="fa fa-plus ml-1" aria-hidden="true"></i> Create Topic  </a>
                                </div>
                            @else
                                    <div class="container">
                                        <table class="table w-100"  >
                                        <thead>
                                            <tr>
                                            <th>Topic Name</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($topics as $data) 
                                            <tr>
                                               <td> {{ $data->title }}</td>     
                                               <td> <input type="checkbox" class="roomselect form-control" name="topic_id[]" value="{{ $data->id }}" >     </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                        


                            
                            @endif
                        </div>

                       
                    <input type="hidden" name="id" value="{{$id}}">
                    </div>
                    @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{route('tribes')}}" class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" id="subm" class="btn btn-primary">@lang('general.save')</button>
                        </div>
                    @endif
                </form>

            </div>

        </div>
    </div>
<script type="text/javascript">
    $("#subm").click(function(e){
        if($(".roomselect:checked").length == 0){
            e.preventDefault();
            alert('Please select atleast 1 topic to proceed'); 
        }
    });
</script>

@endsection


