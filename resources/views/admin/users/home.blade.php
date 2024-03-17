@extends( 'admin.layouts.app' )
@section( 'content' )
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">All Users</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @if (session('success'))

                <div class="alert alert-warning alert-dismissible fade show" role="success">
                  {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                    <!-- <div class="alert  alert-info" style="width: 100%">
                        {{ session('success') }}
                    </div> -->
                @endif
                    @if (session('Fail'))
                     <div class="alert alert-danger alert-dismissible fade show" role="danger">
                   <strong>  {{ session('Fail') }}</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                   <!--  <div class="alert alert-danger" style="width: 100%">
                        {{ session('Failed') }}
                    </div> -->
                @endif
                <h3 class="tile-title">All Users
                    @if(Auth::check() )
                        <a href="{{url('/users/add')}}" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Add User</a>
                @endif              

                &nbsp;&nbsp;&nbsp;<a href="{{url('/users/import')}}" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Import</a>

                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>image</th>
                            <th>@lang('users.name')</th>
                            <th>@lang('users.email')</th>
                            <!-- <th>State</th>
                            <th>City</th>
                            <th>country</th> -->
                            <th>tribes</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($users as $row)
                            <tr @if(count($row->tribe) < 1) style="background: wheat" @endif>

                                <td>
                                    @if($row->image !="")
                                    <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="{{env('APP_URL')}}/images/sucrai/{{$row->image}}" style=" height: 70px !important; width: 68px;border-radius: 30px; ">
                                    @else
                                      <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="{{env('APP_URL')}}/images/sucrai/abc.png" style=" height: 70px !important; width: 68px;border-radius: 30px; ">

                                    @endif

                                  </td>
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                <td <?php if($row->is_blocked=='Yes') echo 'style="color:red;"'; ?> >{{$row->name}}</td>
                                <td style="text-transform: none;">{{$row->email}} </td>

                               <!--  <td>{{$row->state}}</td>
                                <td>{{$row->city}}</td>
                                <td>{{$row->country}}</td> -->
                                <td>
                                    @if(count($row->tribe)>0)
                                    <table class="table-bordered  small">
                                        <thead>
                                        <th>Joined Tribes</th>
                                        <th>Total Answered question</th>
                                     
                                        <th>Remove</th>
                                        <th>Action</th>
                                        </thead>
                                        @foreach($row->tribe as $tr)
                                        <tbody>
                                        <td>  {{$tr->title}}</td>
                                        <td>{{$tr->total_answered_question}}</td>
                                   
                                        <td>
                                            @if(!($tr->leader == $row->id))
                                                <a onclick="RemoveFromTribe({{$tr->id. ','.$row->id}})"  class="btn btn-sm btn-danger" >Remove from this tribe</a>
                                            @endif

                                                @if(($tr->leader == $row->id))
                                               <small class="small">You can't remove this leader from tribe</small>
                                                  @endif

                                        </td>
                                        <td>
                                            @if($tr->leader != $row->id && $tr->leader != 0)
                                                <small class="small">This tribe already has a leader</small>
                                            @elseif($tr->leader == $row->id)
                                                <a href="{{url('/tribe/remove_leader/'. $tr->id)}}" class="btn btn-sm btn-warning " >Remove as tribe leader</a>
                                             @endif



                                                @if($tr->leader == 0)
                                                <a href="{{url('/tribe/make_leader/'. $tr->id , $row->id)}}" class="btn btn-sm btn-success" >Make tribe leader</a>
                                            @endif

                                        </td>


                                        </tbody>
                                        @endforeach

                                    </table>
                                    @endif
                                    @if(count($row->tribe)<1)
                                        <small class="small">This user has't joined any tribe</small>
                                     @endif



                                </td>


                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">

                                        <a href="{{url('users/edit/' . $row->id)}}" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
                                        


                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
    
    <style>
        .sweet-alert h2 {
            font-size: 1.3rem !important;
        }

        .sweet-alert .sa-icon {
            margin: 30px auto 35px !important;
        }
    </style>


    <script>

        $(document).ready(function() {
            $('#example').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
        } );
function RemoveFromTribe(tribe_id,user_id){
    //alert(tribe_id+'----'+user_id);
    let text;
if (confirm("Are you sure you want to remove from this tribe? Press OK to confirm.") == true) {
    location.href = "{{url('/tribe/remove_from_tribe/')}}/"+tribe_id+"/"+user_id;
//location.href =  $('#APP_URL').val()+list_top_boxes+complete_list_size+complete_list_sex+complete_list_frameshapess+complete_list_materialtypess;  
} else {
  text = "You canceled!";
}


}
    </script>
}



@endsection
