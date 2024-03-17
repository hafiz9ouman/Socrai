
<?php $__env->startSection( 'content' ); ?>
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" />

    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Media</li>
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

                                    
                     <?php    $error_mess = explode(';',session('question_import_error')); 
                                     if(count($error_mess) >0) {
                                      foreach($error_mess as $errmess){
                                                if(strlen($errmess) < 3){
                                                    continue;
                                                }
                                                ?>   
                                                      
                                                    <div class="alert alert-danger" style="width: 100%"> 
                                                                <?php echo $errmess; ?>  
                                                            </div>

                                                 <?php
                                      }
                                  }

                             ?>
                <h3 class="tile-title">All Media
                    <?php if(Auth::check() ): ?>
                        <a href="/questions_answers/add/media" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Add Media</a>
                <?php endif; ?>
                <!-- <a href="<?php echo e(url('user/detail')); ?>" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-eye"></i>User Detail</a> -->
                </h3>
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="">#Sr</th>
                            
                            <th>Media</th>
                            <th>Media Type</th>
                            <th>File Name</th>
                            <th>Topic</th>

                            

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td style=""><?php echo $counter;?></td>
                                <?php $counter++;?>

                                 
                                     
                                     <td style="text-transform: none;">

                             

                                




                             <?php if($row->mediatype == 'jpg' || $row->mediatype == 'png'): ?>

                                <a href="https://dev.socrai.com/public/media/questions_answers/<?php echo e($row->file); ?>" data-fancybox="images" data-caption="">
                                    <img src="https://dev.socrai.com/public/media/questions_answers/<?php echo e($row->file); ?>" style="width:50px" />
                                </a>
                             <?php elseif($row->mediatype == 'mp3'): ?>   
                            
                                <img src="<?php echo e(url('public/audio-placeholder.png')); ?>" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a<?php echo e($counter); ?>" href="javascript:;" />
                                        <div style="display: none;" id="hidden-content-a<?php echo e($counter); ?>">
                                            <audio controls  autostart="0" autostart="false" preload ="none">
                                                <source src="https://dev.socrai.com/public/media/questions_answers/<?php echo e($row->file); ?>" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>

                             <?php else: ?>
                              <img src="<?php echo e('https://dev.socrai.com/public/play.png'); ?>" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a<?php echo e($counter); ?>" href="javascript:;" />
                                        <div style="display: none;" id="hidden-content-a<?php echo e($counter); ?>">
                                            <video controls="controls" data-autoplayvideo="false"  data-playvideoonclick="false" sandbox frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="500" height="300" src="https://dev.socrai.com/public/media/questions_answers/<?php echo e($row->file); ?>"></video>
                                        </div>
                               <?php endif; ?>
         
                            
                                 </td>
                                 <td><?php echo e($row->mediatype); ?></td>
                                 <td><?php echo e($row->file); ?></td>
                                 <td><?php echo e(DB::table('topics')->where('id' , $row->topic_id)->pluck('title')->first()); ?></td>

                               

                                <td class="text-center">
                                    <div class="actions-btns dule-btns float-lg-right">
                                        <a href="javascript:void(0)" data-id="<?php echo e($row->id); ?>" class="btn btn-sm btn-danger delete "><i class="fa fa-trash"></i> </a>
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


    <script src="<?php echo e(url('backend/sweetalerts/sweetalert2.all.js')); ?>"></script>
    <script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var task_id = $( this ).attr( "data-id" );
            var form_data = {
                id: task_id
            };
            swal({
                title: "Do you want to delete this Media File",
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
                        url: '<?php echo url("/media/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "<?php echo app('translator')->getFromJson('Media Deleted Successfully'); ?>", '', 'success' )
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
<script type="text/javascript">
    $('[data-fancybox]').fancybox({
        protect: true
    });
</script>

    <script>

        $(document).ready(function() {
            $('#example').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
        } );

    </script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>