

<?php $__env->startSection( 'content' ); ?>
    <div class="app-title">
      
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            
            </li>
            <li class="breadcrumb-item">Edit Pages</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile container">
                <h3 class="tile-title">Pages</h3>
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
                <form class="form-horizontal" method="POST" action="<?php echo e(url('/pages/update')); ?>" enctype="multipart/form-data">

                    


                    <?php echo e(csrf_field()); ?>

                        
                                <h1 class="form-control-label">Terms of use</h1>
                                
                                <textarea   class="form-control " name="terms_of_user" style="width: 100%;" required placeholder="Enter description." maxlength="150"   id="txtEditor2" >
                                        <?php if(isset($data) ): ?>
                                              <?php echo $data->terms_of_user; ?>

                                        <?php endif; ?>
                               </textarea>
                         
                                <hr>

                                <h1 class="form-control-label">Privace Policy - GDPR</h1>
                               
 
                                  <textarea   class="form-control " name="privace_policy"  style="width: 100%;" required placeholder="Enter description." maxlength="150"   id="txtEditor" >
                                      <?php if(isset($data) ): ?>
                                        <?php echo $data->privacy_policy; ?>

                                      <?php endif; ?>  

                        </textarea>
                         <?php if(isset($data)): ?>
                            <input type="hidden"  name="page_id"  value="<?php echo e($data->id); ?>">
                         <?php endif; ?>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(url('pages')); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('general.cancel'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('general.save'); ?></button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>

        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.13.1/full-all/ckeditor.js"></script>
  
    <script>
        $(document).ready(function() {
            // CKEDITOR.replace( 'txtEditor' );



        CKEDITOR.replace('txtEditor', { 
          
            maxLength: 10, 
            toolbar: 'TinyBare', 
            toolbar_TinyBare: [
                 ['Bold','Italic','Underline'],
                 ['Undo','Redo'],['Cut','Copy','Paste'],
                 ['NumberedList','BulletedList','Table'],
            ] 
        });

        CKEDITOR.replace('txtEditor2', { 
          
            maxLength: 10, 
            toolbar: 'TinyBare', 
            toolbar_TinyBare: [
                 ['Bold','Italic','Underline'],
                 ['Undo','Redo'],['Cut','Copy','Paste'],
                 ['NumberedList','BulletedList','Table'],
            ] 
        });





        });



           

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>