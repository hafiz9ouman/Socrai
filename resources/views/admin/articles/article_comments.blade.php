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
            <li class="breadcrumb-item">All Comments for <strong>{{$article_title}}</strong> </li>
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
            
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Title Comments</th>
                            <th>Likes</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($data as $row)
                        <?php

                       // print_r($row);
                        ?>

                           <tr >
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                 <td>
                                    {{$row->comment}}</td>

                                <td>
                                    <?php

$count = DB::table('comment_likes')->where('comment_likes.comment_id' , $row->id)->join('users' , 'users.id' , '=' , 'comment_likes.user_id')->count();
         echo $count;                       

         ?></td>

                                <td>
                             

<a href="javascript:;" data-id="{{$row->id}}" class="btn btn-sm btn-danger delete" style="float: left;"><i class="fa fa-trash"></i><small> Delete</small></a>

&nbsp;
<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="{{'#myModal'. $row->id}}"><i class="fa fa-edit"></i>Edit</a>


                                </td>

                            </tr>


                              <div class="modal fade" id="{{'myModal'. $row->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" action="/article_comments_update">    
        {{ csrf_field() }}
        <div class="modal-content">
        <div class="modal-header" style="display: inline-table;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Comment</h4>
        </div>
        
            <input type="hidden" name="discussions_id" value="{{$row->id}}" />
            <input type="hidden" name="article_id" value="{{$row->article_id}}" />
        <div class="modal-body">
            <div class="form-group">
                                <label class="form-control-label">Comment Title</label>
                                <input id="title" type="text" class="form-control" value="{{$row->comment}}" name="title" required="" >
                            </div>

          <p style="color: black !important;">





            <h6 style="margin-top: 25px;margin-left: -16px;word-break: break-word;">  </h6></p>
        </div>
        
        <div class="modal-footer">
          <input type="submit" class="btn btn-sm btn-success" value="Update" >
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
    </div>
  </div>



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
            //alert('dddddddddddd'+$( this ).attr( "data-id" ));return false;
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to delete this comment?",
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
                        url: '<?php echo url("/delete_comment_post"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "@lang('Comment Deleted Successfully')", '', 'success' )
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
