
<?php $__env->startSection( 'content' ); ?>

<div class="app-title">

<div>
	<h1><i class="fa fa-edit"></i> Media Import</h1>
		<p>Media can me video or images including different types (mp4, jpg, png are supported)</p>
	</div>	

	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
		</li>
		<li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Dashboard</a>
		</li>
	</ul>
</div>

<div class="row">
        <div class="col-md-6">

			<?php if(count($errors) > 0): ?>
				<div class="alert alert-danger">
					<ul>
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			<?php endif; ?>
			<?php if( Session::get('success') ): ?>
				<div class="alert alert-success">
					<ul>
						<li><?php echo e(Session::get('success')); ?></li>
					</ul>
				</div>
			<?php endif; ?>


          <div class="tile">
            <h3 class="tile-title">Import Media</h3>
            <div class="tile-body">
              <form action="<?php echo e(route( 'store.media' )); ?>" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
			  	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <div class="form-group">
                  <label class="control-label">Upload</label>
                  <input class="form-control" type="file" name="file[]" multiple="true">
				</div>
				 <div class="form-group ">
                            <label for="comp">Topic</label>
                            <select name="topic" class="form-control " required>
                                <option value="">--Select Topic--</option>
                                <?php $__currentLoopData = $topic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($xc->id); ?>" ><?php echo e($xc->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
			
				
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit">
				  <i class="fa fa-fw fa-lg fa-check-circle"></i>Import</button>
				  &nbsp;&nbsp;&nbsp;
				  <a class="btn btn-secondary" href="<?php echo e(url('/media/home')); ?>">
					  <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
					  &nbsp;&nbsp;&nbsp;
				  
			</div>
			
			</form>
          </div>
        </div>
      
        <div class="clearix"></div>
        
      </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>