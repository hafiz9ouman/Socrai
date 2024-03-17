
<?php $__env->startSection( 'content' ); ?>
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
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
             <li class="breadcrumb-item"><a href="<?php echo e(url('/questions_answers')); ?>">All Questions Answers</a>
            </li>
             <li class="breadcrumb-item">Add To Exercise</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="tile">
               <!--  <?php if(session('success')): ?>
                    <div class="alert  alert-info" style="width: 100%">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('Failed')): ?>
                    <div class="alert alert-danger" style="width: 100%">
                        <?php echo e(session('Failed')); ?>

                    </div>
                <?php endif; ?> -->
                <h3 class="tile-title">Add Question To Exercise
                   
                </h3>
        <form class="form-horizontal" method="POST" action="<?php echo e(route('store.exercise_question')); ?>" enctype="multipart/form-data" novalidate>
                    <?php echo e(csrf_field()); ?>

                <div class="table-responsive">
                          

        
                              <div class="form-group ">
                                <label for="comp">Add Question To Following Exercise</label>
                                <select name="exercise_id" class="form-control "  required >
                                    <option value="">---  Select exercise  ---</option>
                                    <?php $__currentLoopData = $exercise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($data->id); ?>"><?php echo e($data->question); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <input type="hidden" class="form-control" name="question_id" value="<?php echo e($id); ?>">

                            <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(route('questions_answers')); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('general.cancel'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('general.save'); ?></button>
                        </div>
                    <?php endif; ?>

                     </form>
                </div>
            </div>
        </div>
    </div>


   



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>