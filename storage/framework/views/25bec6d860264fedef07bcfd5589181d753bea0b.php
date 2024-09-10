

<?php $__env->startSection( 'content' ); ?>
    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/site_admin')); ?>">Site Admins</a>
            </li>
            <li class="breadcrumb-item">Add Admin</li>
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
            <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
                <h3 class="tile-title">Add Admin</h3>
                <form class="form-horizontal" method="POST" action="<?php echo e(url('site_admin/store')); ?>" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input  id="image"  type="file" placeholder="image" class="form-control" name="image">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Name</label>
                                <input id="name" type="text" class="form-control " name="name" required >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Email</label>
                                <input id="email"  type="email" class="form-control " autocomplete="off" value="" name="email"  required >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input id="password"  type="password" class="form-control " value=""  autocomplete="off" name="password"  required >
                            </div>
                        </div>


                        <!-- 
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Phone</label>
                                    <input id="phone" type="text" class="form-control" name="phone"  >
                                </div>
                            </div> 
                        -->


                       <!--  <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">State</label>
                                <input id="state" pattern="[a-zA-Z]+"type="text" class="form-control" required="" name="state" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">City</label> 
                                <input id="city" type="text" pattern="[a-zA-Z]+" class="form-control" required="" name="city" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Country</label>
                                <input id="country" type="text" pattern="[a-zA-Z]+" class="form-control" required="" name="country" required  >
                            </div>
                        </div> -->


                    </div>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(url('site_admin')); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('general.cancel'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('general.save'); ?></button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>

        </div>
    </div>


<?php $__env->stopSection(); ?>



<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>