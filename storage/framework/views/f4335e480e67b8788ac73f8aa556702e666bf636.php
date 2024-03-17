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
            <li class="breadcrumb-item">Tribe Leader</li>
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
                <h3 class="tile-title">Tribe Leaders
                    <?php if(Auth::check() ): ?>

                <?php endif; ?>
                <!-- <a href="<?php echo e(url('user/detail')); ?>" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-eye"></i>User Detail</a> -->
                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Image</th>
                            <th>Tribe</th>                            
                            <th>Leader Name</th>
                            <th>Email</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;


                        ?>
                        <?php if($data != 'false'): ?>
                        

                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           
                            <tr  {{ <?php if($data != 'false'): ?> < 1)  <?php endif; ?> >
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>

                                <td>
                                    <img class=" img-circle img-size-32 mr-2 round_img"  height="15%" src="<?php echo e(env('APP_URL')); ?>/images/sucrai/<?php if(isset($row->leader->image)) echo $row->leader->image; ?>" style=" height: 70px !important;
            width: 68px;
            border-radius: 30px; ">
                                </td>
                                <td>
                                    <small><?php echo e($row->title); ?></small>

                                </td>
                                <td>
                                   <small> <?php if(isset($row->leader->name)) echo $row->leader->name; ?></small>
                                </td>
                                <td>
                                    <small> <?php if(isset($row->leader->email)) echo $row->leader->email; ?></small>
                                </td>


                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                        <a href="<?php echo e(url('/tribe/remove_leader/' . $row->id)); ?>" class="btn btn-sm btn-danger" style="float: left;"><i class="fa fa-trash"></i><small> Remove Leader</small></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
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
                id: task_id
            };
            swal({
                title: "Do you want to delete this Category",
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
                        url: '<?php echo url("users/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "<?php echo app('translator')->getFromJson('Category Deleted Successfully'); ?>", '', 'success' )
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



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>