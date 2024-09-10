

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
            <li class="breadcrumb-item"><a href="<?php echo e(route('topics')); ?>">All topics</a>
            </li>
            <li class="breadcrumb-item">Edit Topic</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <h3 class="tile-title">Edit Topic</h3>
                <form class="form-horizontal" method="POST" action="/topics/update" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">


                        <input type="hidden" name="id" value="<?php echo e($id); ?>">
                        
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Title</label>
                                <input id="title" type="text" class="form-control" value="<?php echo e($topic->title); ?>" name="title" required >
                            </div>
                        </div>


                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Point for Question</label>
                                <input value="<?php echo e($topic->question_points); ?>" id="question_points" type="number" class="form-control " name="question_points" required>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Point for Exercise</label>
                                <input value="<?php echo e($topic->exercise_points); ?>" id="exercise_points" type="number" class="form-control " name="exercise_points" required>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Correct Exercise Point</label>
                                <input value="<?php echo e($topic->exercise_points_correct); ?>" id="exercise_points_correct" type="number" class="form-control " name="exercise_points_correct" required>
                            </div>
                        </div>


                       



                    </div>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(route('topics')); ?>" class="btn btn-default"><?php echo app('translator')->get('general.cancel'); ?></a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>

        </div>
    </div>


<?php $__env->stopSection(); ?>



<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/topics/edit.blade.php ENDPATH**/ ?>