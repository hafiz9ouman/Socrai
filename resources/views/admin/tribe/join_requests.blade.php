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
            
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
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
                 <?php    $error_mess = explode(',',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   
                                  
                                <div class="alert alert-warning" style="width: 100%">
                                            {{ $errmess }}
                                        </div>

                             <?php
                  }
              }

         ?>
                <h3 class="tile-title">Join requests
                    
                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Tribe Name</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Total Joined Users</th>
                            <th>Total Topics</th>
                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($data as $row)

                            <tr>
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>


                                <td>{{$row->tribe_name}}</td>
                                <td> {{ $row->user_name }}  </td>
                                 <td> {{ $row->user_email }}  </td>

                                <td>
                                  <?php  
                                    if(DB::table('user_tribes')->where('tribe_id' , $row->tribe_id)->count() == 0){
                                      ?>   
                                        <a class="btn btn-sm btn-warning"> No user available </a> 
                                      <?php              
                                    }
                                    else{
                                        ?>
                                         <a class="btn btn-sm btn-warning">joined by {{DB::table('user_tribes')->where('tribe_id' , $row->tribe_id)->count()}} users </a> 
                                         <?php
                                    }       
                                    ?>
                                   
                                     
                                </td>

                                 <td>
                                    
                                        @php
                                            $topic_count = DB::table('topics')->where('tribe_id',$row->id)->count();
                                        @endphp
                                        @if($topic_count == 0)
                                         <small>No topic added</small>       
                                         @else
                                            {{$topic_count}}
                                        @endif
                                   

                                </td>

                                


                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                       
                         <a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-success approve_request" style="float: left;"><i class="fa fa-check-circle mr-1" aria-hidden="true"></i> Approve</a>

                         <a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-danger delete "><i class="fa fa-ban mr-1" aria-hidden="true"></i> <small>Decline</small></a>

                                         
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

    <div class="modal" id="div_dbReadMany" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content modal-info">
            <div class="modal-header">
                
            </div>
            <div class="modal-body">
                <form class="form">
                <input type="text" value="askjdhakjhd askdh aksdh ka hdjka hd">
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success save" >Ok</button>
            </div>
        </div>
    </div>
</div>


    <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script>
    <script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to Reject this request",
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
                        url: '<?php echo url("join_requests/reject"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "@lang('Request is rejected')", '', 'success' )
                            setTimeout( function () {
                                location.reload();
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>



     <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script>
    <script type="text/javascript">
        $( "body" ).on( "click", ".approve_request", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to Approve this request",
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
                        url: '<?php echo url("/join_requests/approve"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "@lang('User joined tribe successfully')", '', 'success' )
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
        } );

    </script>



@endsection
