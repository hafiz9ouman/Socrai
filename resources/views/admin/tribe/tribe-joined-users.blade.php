@extends( 'admin.layouts.app' )
@section( 'content' )
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/tribes')}}">Manage Tribe</a>
            </li>
            <li class="breadcrumb-item">All Joined Users</li>
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
                <h3 class="tile-title">Total Joined User in tribe: {{ $tribe->title }}

                </h3>
                <div class="table-responsive">

                    <table id = "example" class="table small border-bottom">
                        <thead class="back_blue">
                        <tr>
                            <th style="">#Sr</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Detail</th>


                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                            {{--                             @if(count($row->tribe) < 1) style="background: wheat" @endif--}}
                        @foreach($user as $row)
                            <tr class="small" >
                                <td style=""><?php echo $counter;?></td>
                                <?php $counter++;?>
                                <td>
                                   
			
			
			@if( $row->image == "" )
								
                                    <img class=" img-circle img-size-32 mr-2 round_img"  height="15%" src="/male-placeholder.jpg" style=" height: 70px !important;
            width: 68px;
            border-radius: 30px; ">
			
						@else 
							 <img class=" img-circle img-size-32 mr-2 round_img"  height="15%" src="/images/sucrai/{{$row->image}}" style=" height: 70px !important;
            width: 68px;
            border-radius: 30px; ">
						@endif
						
						
                                </td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->country}}</td>

                                <td>
                                    @if($row->user_role == '1')
                                        <a href="" class="btn btn-sm btn-dark" ><i class="fa fa-certificate" aria-hidden="true"></i></i>Web Admin </a>
                                    @endif
                                    @if($row->user_role == '2')
                                        <a href="" class="btn btn-sm btn-warning" ><i class="fa fa-star" ></i><small>socrai Leader</small> </a>
                                    @endif
                                    @if($tribe->leader == $row->id)
                                        <a href="" class="btn btn-sm btn-dark" ><i class="fa fa-check-circle" ></i><small>Tribe Leader</small> </a>
                                    @endif

                                </td>


                                

                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                        <a href="{{url('users/edit/' . $row->id)}}" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
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


    <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script>
    <script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id,
                tribe_id: {{$tribe->id }}
            };
            swal({
                title: "Do you want to Remove this User",
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
                        url: '<?php echo url("/tribe/remove/user/from/tribe"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "@lang('User removed from tribe')", '', 'success' )
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
                "order": [[ 0, "asc" ]]
            } );
        } );

    </script>



@endsection
