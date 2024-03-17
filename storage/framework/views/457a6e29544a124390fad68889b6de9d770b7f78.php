<?php $__env->startSection( 'content' ); ?>
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
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/tribes')); ?>">Manage Tribe</a>
            </li>
            <li class="breadcrumb-item">All Joined Users</li>
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
                <h3 class="tile-title">Total Joined User in tribe: <?php echo e($tribe->title); ?>


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
                            
                        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="small" >
                                <td style=""><?php echo $counter;?></td>
                                <?php $counter++;?>
                                <td>
                                   
			
			
			<?php if( $row->image == "" ): ?>
								
                                    <img class=" img-circle img-size-32 mr-2 round_img"  height="15%" src="/public/male-placeholder.jpg" style=" height: 70px !important;
            width: 68px;
            border-radius: 30px; ">
			
						<?php else: ?> 
							 <img class=" img-circle img-size-32 mr-2 round_img"  height="15%" src="/public/images/sucrai/<?php echo e($row->image); ?>" style=" height: 70px !important;
            width: 68px;
            border-radius: 30px; ">
						<?php endif; ?>
						
						
                                </td>
                                <td><?php echo e($row->name); ?></td>
                                <td><?php echo e($row->email); ?></td>
                                <td><?php echo e($row->country); ?></td>

                                <td>
                                    <?php if($row->user_role == '1'): ?>
                                        <a href="" class="btn btn-sm btn-dark" ><i class="fa fa-certificate" aria-hidden="true"></i></i>Web Admin </a>
                                    <?php endif; ?>
                                    <?php if($row->user_role == '2'): ?>
                                        <a href="" class="btn btn-sm btn-warning" ><i class="fa fa-star" ></i><small>socrai Leader</small> </a>
                                    <?php endif; ?>
                                    <?php if($tribe->leader == $row->id): ?>
                                        <a href="" class="btn btn-sm btn-dark" ><i class="fa fa-check-circle" ></i><small>Tribe Leader</small> </a>
                                    <?php endif; ?>

                                </td>


                                

                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                        <a href="<?php echo e(url('users/edit/' . $row->id)); ?>" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" data-id="<?php echo e($row->id); ?>" class="btn btn-sm btn-danger delete "><i class="fa fa-trash"></i></a>
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


    <script src="<?php echo e(url('backend/sweetalerts/sweetalert2.all.js')); ?>"></script>
    <script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id,
                tribe_id: <?php echo e($tribe->id); ?>

            };
            swal({
                title: "Do you want to Remove this User",
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
                        url: '<?php echo url("/tribe/remove/user/from/tribe"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "<?php echo app('translator')->getFromJson('User removed from tribe'); ?>", '', 'success' )
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



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>