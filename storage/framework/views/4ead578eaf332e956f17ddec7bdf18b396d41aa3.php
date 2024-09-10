

<?php $__env->startSection( 'content' ); ?>
    <div class="app-title">
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
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('tribes')); ?>">All Tribes</a>
            </li>
            <li class="breadcrumb-item">Add Topic</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile container">
                <h3 class="tile-title">Add Topic</h3>
                <form class="form-horizontal" method="POST" action="/tribe_topic_store" enctype="multipart/form-data">
                         <?php echo e(csrf_field()); ?>

                    <div class="row">


                
                        <div class="w-100">
                            <!-- <label for="comp">Topics</label> -->
                            <?php if(!isset($topics) || !(count($topics)) ): ?>
                                <div class=" text-center"> 
                                        <img src="<?php echo e(url('/images/sucrai/warning.webp')); ?>" style="width: 25%;" class="text-center">

                                        <h5 class="text-center">There are no topic available right now!</h5>
                                        <a href="<?php echo e(url('topics/add')); ?>" class="btn  btn-warning"> <i class="fa fa-plus ml-1" aria-hidden="true"></i> Create Topic  </a>
                                </div>
                            <?php else: ?>
                                    <div class="container">
                                        <table class="table w-100"  >
                                        <thead>
                                            <tr>
                                            <th>Topic Name</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <tr>
                                               <td> <?php echo e($data->title); ?></td>     
                                               <td> <input type="checkbox" class="roomselect form-control" name="topic_id[]" value="<?php echo e($data->id); ?>" >     </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    </div>
                        


                            
                            <?php endif; ?>
                        </div>

                       
                    <input type="hidden" name="id" value="<?php echo e($id); ?>">
                    </div>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(route('tribes')); ?>" class="btn btn-default"><?php echo app('translator')->get('general.cancel'); ?></a>
                            <button type="submit" id="subm" class="btn btn-primary"><?php echo app('translator')->get('general.save'); ?></button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>

        </div>
    </div>
<script type="text/javascript">
    $("#subm").click(function(e){
        if($(".roomselect:checked").length == 0){
            e.preventDefault();
            alert('Please select atleast 1 topic to proceed'); 
        }
    });
</script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/tribe/add_topic.blade.php ENDPATH**/ ?>