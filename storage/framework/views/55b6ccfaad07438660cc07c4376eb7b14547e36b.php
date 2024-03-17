<?php $__env->startSection( 'content' ); ?>
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
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Manage Tribes</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <?php if(session('success')): ?>
                    <div class="alert  alert-info" style="width: 100%">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('Failed')): ?>
                    <div class="alert alert-danger" style="width: 100%">
                        <?php echo e(session('Failed')); ?>

                    </div>
                <?php endif; ?>
                 <?php    $error_mess = explode(',',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   
                                  
                                <div class="alert alert-warning" style="width: 100%">
                                            <?php echo e($errmess); ?>

                                        </div>

                             <?php
                  }
              }

         ?>
                <h3 class="tile-title">Tribes
                    <?php if(Auth::check() ): ?>
                        <a href="/tribes_add" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Add Tribe</a>
                <?php endif; ?>
                <!-- <a href="<?php echo e(url('user/detail')); ?>" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-eye"></i>User Detail</a> -->
                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Tribe Title</th>
                            
                            <th>Tribe Leader</th>
                            
                            <th>Total Topics</th>
                            
                            <th>View / Edit joined users</th>
                            <th>Manage Articles</th>
                            <th>Add User</th>
                            <th>Add Topics</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>


                                <td><?php echo e($row->title); ?></td>
                                
                                <td><?php echo e(DB::table('users')->where('id' , $row->leader)->pluck('name')->first()); ?></td>
                               

                                 <td>
                                    
                                        <?php
                                            $topic_count = DB::table('topics')->where('tribe_id',$row->id)->count();
                                        ?>
                                        <?php if($topic_count == 0): ?>
                                         <small>No topic added</small>       
                                         <?php else: ?>
                                            <?php echo e($topic_count); ?>

                                        <?php endif; ?>
                                   

                                </td>
                                 
                                            
                                            <?php  
                                                $user_joined = 0;
                                                if($row->user != 'false'){
                                            $user_joined = count($row->user);}
                                              ?>
                                                                                        

                                 

                                

                                <td>
                                
                                      <button <?php if($user_joined == 0): ?> disabled <?php endif; ?>   class="btn btn-sm btn-warning" style=""> <a style="color: black;" <?php if($user_joined != 0): ?> href="<?php echo e(url('/tribe/user_detail/' . $row->id)); ?>" <?php endif; ?>> <i class="fa fa-edit" style="color: black;"> </i><strong><?php echo e($user_joined); ?> </strong><small>Joined Users</small></a></button>
                                    
                                </td>
                                <?php $art_count = DB::table('articles')->where('tribe_id' , $row->id)->count(); ?>
                                <td><button class="btn btn-dark btn-sm" <?php if($art_count <= 0): ?> disabled <?php endif; ?> style="color:white;" data-toggle="modal" data-target="#exampleModal" onclick=" myFun( <?php echo e($row->id); ?> ) " ><strong><?php echo e($art_count); ?></strong> Articles  <i class="fa fa-newspaper-o ml-2" aria-hidden="true"></i></button></td>
                               

                                <td >

                                    <a href="<?php echo e(url('/tribe/adduser/' . $row->id)); ?>" class="btn btn-sm btn-info center"><i class="fa fa-plus"> </i> <small>Add</small></a>
                                </td>

                                 <td>
                                      <a href="<?php echo e(url('/tribe_add_topic/' . $row->id)); ?>" class="btn btn-sm btn-info center"><i class="fa fa-book"> </i> <small>Topic</small></a>
                                </td>


                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                        <?php if(auth()->user()->role_id == 1): ?>
                                        <a href="javascript:void(0)" data-id="<?php echo e($row->id); ?>" class="btn btn-sm btn-danger delete "><i class="fa fa-trash"></i> <small>Delete Tribe</small></a>
                                        <?php endif; ?>

                                         <a href="<?php echo e(url('/tribes/edit/' . $row->id)); ?>" class="btn btn-sm btn-warning" style="float: left;"><i class="fa fa-edit"></i> Edit Tribe</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<!-- Article Model -->


<div id="exampleModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="tribe_title"></h4>
        
        
      </div>
      <div class="modal-body">
         <table style="width: 100% !important" class="table table-bordered table-responsive">
             <thead>
                 <tr>
                     
                     <th>Article name</th>
                     <th>Number of comments</th>
                     
                     <th>See details</th>
                 </tr>
             </thead>
             <tbody id="data_show"></tbody>
         </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <script src="<?php echo e(url('backend/sweetalerts/sweetalert2.all.js')); ?>"></script>
    <script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to delete this Tribe",
                //text: "<?php echo app('translator')->getFromJson('category.delete_category_msg'); ?>",
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
                        url: '<?php echo url("/tribe/store/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "<?php echo app('translator')->getFromJson('Tribe Deleted Successfully'); ?>", '', 'success' )
                            setTimeout( function () {
                                location.reload();
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>
    <script type="text/javascript">
        function myFun(tribe_id){
                    var form_data = {

                // course_id: course_id,
                tribe_id: tribe_id,

            };
       $.ajax({

                        type: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                        },

                        url: '<?php echo url("tribe/get/articles"); ?>',

                        data: form_data,

                        success: function ( msg ) {

                           $('#data_show').html(msg);

                           

                        }

                    });

        }
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



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>