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
            <li class="breadcrumb-item">All Users</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <?php if(session('success')): ?>

                <div class="alert alert-warning alert-dismissible fade show" role="success">
                  <?php echo e(session('success')); ?>

                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                    <!-- <div class="alert  alert-info" style="width: 100%">
                        <?php echo e(session('success')); ?>

                    </div> -->
                <?php endif; ?>
                    <?php if(session('Fail')): ?>
                     <div class="alert alert-danger alert-dismissible fade show" role="danger">
                   <strong>  <?php echo e(session('Fail')); ?></strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                   <!--  <div class="alert alert-danger" style="width: 100%">
                        <?php echo e(session('Failed')); ?>

                    </div> -->
                <?php endif; ?>
                <h3 class="tile-title">All Users
                    <?php if(Auth::check() ): ?>
                        <a href="<?php echo e(url('/users/add')); ?>" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Add User</a>
                <?php endif; ?>              

                &nbsp;&nbsp;&nbsp;<a href="<?php echo e(url('/users/import')); ?>" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Import</a>

                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>image</th>
                            <th><?php echo app('translator')->get('users.name'); ?></th>
                            <th><?php echo app('translator')->get('users.email'); ?></th>
                            <!-- <th>State</th>
                            <th>City</th>
                            <th>country</th> -->
                            <th>tribes</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr <?php if(count($row->tribe) < 1): ?> style="background: wheat" <?php endif; ?>>

                                <td>
                                    <?php if($row->image !=""): ?>
                                    <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="<?php echo e(env('APP_URL')); ?>/images/sucrai/<?php echo e($row->image); ?>" style=" height: 70px !important; width: 68px;border-radius: 30px; ">
                                    <?php else: ?>
                                      <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="<?php echo e(env('APP_URL')); ?>/images/sucrai/abc.png" style=" height: 70px !important; width: 68px;border-radius: 30px; ">

                                    <?php endif; ?>

                                  </td>
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                <td <?php if($row->is_blocked=='Yes') echo 'style="color:red;"'; ?> ><?php echo e($row->name); ?></td>
                                <td style="text-transform: none;"><?php echo e($row->email); ?> </td>

                               <!--  <td><?php echo e($row->state); ?></td>
                                <td><?php echo e($row->city); ?></td>
                                <td><?php echo e($row->country); ?></td> -->
                                <td>
                                    <?php if(count($row->tribe)>0): ?>
                                    <table class="table-bordered  small">
                                        <thead>
                                        <th>Joined Tribes</th>
                                        <th>Total Answered question</th>
                                     
                                        <th>Remove</th>
                                        <th>Action</th>
                                        </thead>
                                        <?php $__currentLoopData = $row->tribe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tbody>
                                        <td>  <?php echo e($tr->title); ?></td>
                                        <td><?php echo e($tr->total_answered_question); ?></td>
                                   
                                        <td>
                                            <?php if(!($tr->leader == $row->id)): ?>
                                                <a onclick="RemoveFromTribe(<?php echo e($tr->id. ','.$row->id); ?>)"  class="btn btn-sm btn-danger" >Remove from this tribe</a>
                                            <?php endif; ?>

                                                <?php if(($tr->leader == $row->id)): ?>
                                               <small class="small">You can't remove this leader from tribe</small>
                                                  <?php endif; ?>

                                        </td>
                                        <td>
                                            <?php if($tr->leader != $row->id && $tr->leader != 0): ?>
                                                <small class="small">This tribe already has a leader</small>
                                            <?php elseif($tr->leader == $row->id): ?>
                                                <a href="<?php echo e(url('/tribe/remove_leader/'. $tr->id)); ?>" class="btn btn-sm btn-warning " >Remove as tribe leader</a>
                                             <?php endif; ?>



                                                <?php if($tr->leader == 0): ?>
                                                <a href="<?php echo e(url('/tribe/make_leader/'. $tr->id , $row->id)); ?>" class="btn btn-sm btn-success" >Make tribe leader</a>
                                            <?php endif; ?>

                                        </td>


                                        </tbody>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </table>
                                    <?php endif; ?>
                                    <?php if(count($row->tribe)<1): ?>
                                        <small class="small">This user has't joined any tribe</small>
                                     <?php endif; ?>



                                </td>


                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">

                                        <a href="<?php echo e(url('users/edit/' . $row->id)); ?>" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
                                        


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
    location.href = "<?php echo e(url('/tribe/remove_from_tribe/')); ?>/"+tribe_id+"/"+user_id;
//location.href =  $('#APP_URL').val()+list_top_boxes+complete_list_size+complete_list_sex+complete_list_frameshapess+complete_list_materialtypess;  
} else {
  text = "You canceled!";
}


}
    </script>
}



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/users/home.blade.php ENDPATH**/ ?>