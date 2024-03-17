

<?php $__env->startSection( 'content' ); ?>
	<div class="app-title">

		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
			</li>
			<li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
			</li>
			<li class="breadcrumb-item"><a href="<?php echo e(url('/users')); ?>">All Users</a>
			</li>
			<li class="breadcrumb-item">Edit User</li>
		</ul>
	</div>
<div class="row">
	<div class="col-md-12">


			<?php if(session()->has('error')): ?>
			    <div class="alert alert-danger">
			        <?php echo e(session()->get('error')); ?>

			    </div>
			<?php endif; ?>
			<?php if(session()->has('alert')): ?>
			    <div class="alert alert-alert">
			        <?php echo e(session()->get('alert')); ?>

			    </div>
			<?php endif; ?>

			

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


			<div class="tile">
				<h3 class="tile-title">Edit User</h3>
				<form class="form-horizontal" method="POST" action="<?php echo e(url('/site_admin/update')); ?>" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<div class="row">
						   <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input  id="image"  type="file" placeholder="image" value="<?php echo e($user->image); ?>" class="form-control" name="image">
                            </div>
                        </div>

						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Name</label>
								<input id="name" type="text" class="form-control " name="name" value="<?php echo e($user->name); ?>"  autofocus>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Email</label>
								<input id="email"  type="email" class="form-control " name="email" value="<?php echo e($user->email); ?>"  >
							</div>
						</div>
				


                       
						
						
		

		
	<?php
	$user_id = Request::segment(3);
	?>
	<?php if( twoFactorExists($user_id) ): ?>
	<div class="col-sm-6 col-md-4">
	<div class="form-group">
		<a href="<?php echo e(url('/2fa/disable/' . $user_id )); ?>" class="btn btn-xs btn-info pull-right">Disable 2FA</a>
	</div>
	</div>
	<?php endif; ?>
						
						
						

					<input id="file" type="hidden" class="form-control" name="id" value="<?php echo e($user->id); ?>">

                    </div>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(url('users')); ?>" class="btn btn-primary"><?php echo app('translator')->getFromJson('general.cancel'); ?></a>
                            <button type="submit" class="btn btn-success"><?php echo app('translator')->getFromJson('general.save'); ?></button>
                        </div>
                    <?php endif; ?>
				</form>

			</div>

	</div>
</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>