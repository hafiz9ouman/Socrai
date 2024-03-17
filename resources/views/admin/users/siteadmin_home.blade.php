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
                
                <a data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-warning pull-right"> <i class="fa fa-star mr-2" aria-hidden="true"></i>Make user site admin</a>
                <h3 class="tile-title">All Site Admins</h3>
               
                 

                    @if(auth()->user()->user_role == '1')
                        <a href="{{ url('/site_admin/add') }}" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Add Admin</a>



                     @endif   
                     
                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>image</th>
                            <th>@lang('users.name')</th>
                            <th>@lang('users.email')</th>
                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($data as $row)
                            <tr >

                                <td>
                                    @if($row->image !="")
                                    <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="{{env('APP_URL')}}/images/sucrai/{{$row->image}}" style=" height: 70px !important; width: 68px;border-radius: 30px; ">
                                    @else
                                      <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="{{env('APP_URL')}}/images/sucrai/abc.png" style=" height: 70px !important; width: 68px;border-radius: 30px; ">

                                    @endif

                                  </td>
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                <td>{{$row->name}}</td>
                                <td style="text-transform: none;">{{$row->email}} </td>

                             
                               
                                  


                                     
                                 



                                


                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">

                                        <a href="{{url('site_admin/edit/' . $row->id)}}" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-danger delete "><i class="fa fa-trash"></i></a>


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
   


    <!-- Modal -->
<div id="myModal" class="modal fade " role="dialog">
  <div class="modal-dialog" style="max-width: 700px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <?php $datum = DB::table('users')->where('user_role' , '!=' , '1')->get();   ?>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select a user to make him or her site admin</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
                    <table id = "example2" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>image</th>
                            <th>@lang('users.name')</th>
                            <th>@lang('users.email')</th>
                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($datum as $user)
                            <tr >

                                <td>
                                    @if($user->image !="")
                                    <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="/images/sucrai/{{$user->image}}" style=" height: 70px !important; width: 68px;border-radius: 30px; ">
                                    @else
                                      <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="/images/sucrai/abc.png" style=" height: 70px !important; width: 68px;border-radius: 30px; ">

                                    @endif

                                  </td>
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                <td>{{$user->name}}</td>
                                <td style="text-transform: none;">{{$user->email}} </td>

                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                        <a href="javascript:void(0)" data-id="{{$user->id}}" class="btn btn-sm btn-success make_admin "><i class="fa fa-check-circle" aria-hidden="true"></i></a>


                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
{{-- for make admin --}}
<script type="text/javascript">
        $( "body" ).on( "click", ".make_admin", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to make this user Site Admin",
                //text: "@lang('category.delete_category_msg')",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#F79426',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true
            }).then( ( result ) => {
                if ( result.value == true ) {
                    $.ajax( {
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                        },
                        url: '<?php echo url("/site_admin/normal_user/create_admin"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( msg+' is now site admin', '', 'success' )
                            setTimeout( function () {
                                location.reload();
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>



   {{-- fro delet --}}
    <script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to delete this Admin",
                //text: "@lang('category.delete_category_msg')",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#F79426',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true
            }).then( ( result ) => {
                if ( result.value == true ) {
                    $.ajax( {
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                        },
                        url: '<?php echo url("users/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "@lang('Admin Deleted Successfully')", '', 'success' )
                            setTimeout( function () {
                                location.reload();
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>
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
                        $('#example2').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
        } );

    </script>



@endsection
