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
            <li class="breadcrumb-item">Add User</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile ">
                <h3 class="tile-title ">Add User</h3>
                <form class="form-horizontal" id="form" method="POST" action="/tribe_user_store" enctype="multipart/form-data">

                    <div class="row ">


                    {{ csrf_field() }}
                       <!--  <div class="col-sm-6 col-md-4 ">
                            <label for="comp">Users</label>
                            
                            <select name="user_id" id="topic_id" class="form-control "  required >
                                <option value="">--- Select User  ---</option>
                                @foreach ($users as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                       
                        </div> -->
                        <div class="align_input" style="    width: 100%;display: flex;justify-content: flex-end; margin-bottom: 10px;">
                        <input style="    max-width: 20%;    margin-right: 15px;" class="form-control" id="myInput" type="text" placeholder="Search..">
                            
                        </div>

                        <table  class="table table-hover">
                                <thead>
                                       <tr>
                                                    <th>Image</th>
                                                    <th> Name </th>
                                                    <th>E-mail</th>
                                                    <th>Select User</th>

                                                    
                                       </tr>
                                </thead>
                                <tbody id="myTable">
                                         @foreach($users as $data)
                                         <tr>
                                                
                                               
                                                <td>
                                            @if($data->image == '')
                                            <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="/images/sucrai/abc.png " style=" height: 70px !important;width: 68px; border-radius: 30px;">
                                            @else
                                            <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="/images/sucrai/{{$data->image}} " style=" height: 70px !important;width: 68px; border-radius: 30px;">
                                            @endif        
                                        </td>

                                                <td>{{$data->name}}</td>
                                                <td>{{$data->email}}</td>
                                                 <td>
                                                    <div class="form-check ">
                                                        <input type="checkbox"  value="{{$data->id}}"     name="user_id[]" class="form-check-input roomselect" id="{{$data->id}}">
                                                      </div>
                                                </td>


                                         </tr>
                                        @endforeach

                                

                                </tbody>

                        </table>

                       
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

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
    $('#myInput').on('keypress', function(e) {
        return e.which !== 13;
    });

});

</script>
<script type="text/javascript">
    $("#subm").click(function(e){
        if($(".roomselect:checked").length == 0){
            e.preventDefault();
            alert('Please select atleast 1 user to proceed'); 
        }
    });
</script>


@endsection


