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
            <?php 
if (count($errors) > 0){
	

?>
	<ul>
                    <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

	<?php
}

?>


			<div class="tile">
				<h3 class="tile-title">Edit User</h3>
				<form class="form-horizontal" method="POST" action="<?php echo e(url('users/update')); ?>" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<div class="row">
						   <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input  id="image"  type="file" placeholder="image" value="<?php if(isset($user->image) && $user->image!='') echo $user->image; ?>" class="form-control" name="image">
                            </div>
                        </div>

						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Name</label>
								<input id="name" type="text" class="form-control " name="name" value="<?php if(isset($user->name) && $user->name!='') echo $user->name; ?>"  autofocus>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Email</label>
								<input id="email"  type="email" class="form-control " name="email" value="<?php if(isset($user->email) && $user->email!='') echo $user->email; ?>"  >
							</div>
						</div>
						     <!--  <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input id="password"  type="password" class="form-control " value=""  placeholder="Add New Password" autocomplete="off" name="password"   >
                            </div>
                        </div>
 -->
					

						<!-- <div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">State</label>
								<input id="state" type="text" class="form-control" name="state" value="<?php if(isset($user->state) && $user->state!='') echo $user->state; ?>">
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">City</label>
								<input id="city" type="text" class="form-control" name="city" value="<?php if(isset($user->city) && $user->city!='') echo $user->city; ?>">
							</div>
						</div>
                        <div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label class="form-control-label">Street name</label>
								<input id="country" type="text" class="form-control" name="country" value="<?php if(isset($user->country) && $user->country!='') echo $user->country; ?>">
							</div>
						</div> -->


                        <div class="col-sm-6 col-md-4 ">
                            <label for="comp">Select Tribe to Join</label> <small>Optional</small>
                            <select name="tribe_id" class="form-control" >
                                <option   selected>Select</option>
                                <?php $__currentLoopData = $tribe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($comp->id); ?>"><?php echo e($comp->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>



<div class="col-sm-6 col-md-4 ">
                            <label for="comp">Select Blocked</label> 
                            <select name="is_blocked" class="form-control" >
                                
                                
                                    <option value="No" <?php if($user->is_blocked=='No') {?> selected <?php } ?> >No</option>
			<option value="Yes" <?php if($user->is_blocked=='Yes') {?> selected <?php } ?> >Yes</option>
                                
                            </select>
                        </div>
						
	<div class="col-sm-6 col-md-4 ">
                            <label for="comp">Is Email Varified?</label> 
                            <select name="is_email_varified" class="form-control" >
                                
                                
              <option value="0" <?php if($user->is_email_varified=='0') {?> selected <?php } ?> >No</option>
			<option value="1" <?php if($user->is_email_varified=='1') {?> selected <?php } ?> >Yes</option>
                                
                            </select>
                        </div>




		<div class="col-sm-6 col-md-4 ">
                            <label for="comp">Password</label>
                            
                            <input id="password"  type="text" class="form-control " name="password" value=""  >

                        </div>

						<div class="col-sm-6 col-md-4 ">
                            <label for="comp">Confirm Password</label>
                            
                            <input id="confirm_password"  type="text" class="form-control " name="confirm_password" value=""  >

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
		<a href="javascript:;" class="btn btn-danger delete ">Delete</a>
			    
		
		

	
                        </div>
                    <?php endif; ?>
				</form>

			</div>

	</div>
</div>
<script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = <?php echo e($user->id); ?>;

            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to delete this User",
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
                            swal( "<?php echo app('translator')->getFromJson('User Deleted Successfully'); ?>", '', 'success' )
                            setTimeout( function () {
                                location.reload();
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>