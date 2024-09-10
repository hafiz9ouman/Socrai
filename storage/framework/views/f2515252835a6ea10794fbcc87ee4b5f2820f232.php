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
            <li class="breadcrumb-item">Edit Tribe</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <h3 class="tile-title">Edit Tribe</h3>
                <form class="form-horizontal" method="POST" action="<?php echo e(url('/tribe/update_data')); ?>" enctype="multipart/form-data">

                    <div class="row">


                    <?php echo e(csrf_field()); ?>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Title</label>
                                <input id="title" type="text" class="form-control" value="<?php echo e($data->title); ?>" name="title" required placeholder="Enter title.">
                            </div>
                       
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <!-- <textarea class="form-control " name="description" required placeholder="Enter description." id="description"></textarea> -->
 
                                  <textarea   class="form-control"  name="description" required placeholder="Enter description." maxlength="150"   id="txtEditor" >

                                   <?php echo $data->description; ?>


                               </textarea>
                               <input type="hidden" name="tribe_id"  value="<?php echo e($id); ?>">
                            </div>
                        </div>                       

                    </div>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(route('tribes')); ?>" class="btn btn-default"><?php echo app('translator')->get('general.cancel'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('general.save'); ?></button>
				<a href="javascript:;" class="btn btn-danger delete ">Delete</a>

                        </div>
                    <?php endif; ?>
                </form>

            </div>

        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.13.1/full-all/ckeditor.js"></script>
  
    <script>

        // CKEDITOR.instances["my-content"].setData("<p>Hello World</p>");
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
            // var des = document.getElementById('fetch_desc');
       // CKEDITOR.instances["txtEditor"].setData(v);



        });



           

    </script>



<script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var tribe_id = <?php echo e($id); ?>;

            var form_data = {
                id: tribe_id
            };
            swal({
                title: "Deleting this tribe will delete everything for this tribe ( Users,topics,articles etc)",
                //text: "<?php echo app('translator')->get('category.delete_category_msg'); ?>",
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
                        url: '<?php echo url("tribes/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
alert(msg);return false;
                            swal( "<?php echo app('translator')->get('Tribe Deleted Successfully'); ?>", '', 'success' )
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
<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\socrai.com8\socrai.com\resources\views/admin/tribe/edit_tribe.blade.php ENDPATH**/ ?>