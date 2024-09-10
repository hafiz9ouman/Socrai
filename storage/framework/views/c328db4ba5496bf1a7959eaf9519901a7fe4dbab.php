<?php $__env->startSection('title', 'Add Questions Answers'); ?>

<?php $__env->startSection( 'content' ); ?>
<div class="app-title">

    <div>
        <h1><i class="fa fa-dashboard"></i> Question and Answers</h1>
        <p>Add Question and Answers</p>
    </div>


    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
        </li>
        <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="<?php echo e(url('/questions_answers')); ?>">All Questions Answers</a>
        </li>
        <li class="breadcrumb-item">Add Questions Answers</li>
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
            <h3 class="tile-title">Add Questions & Answer</h3>
            <form class="form-horizontal" method="POST" action="<?php echo e(route('store.question')); ?>" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label">Question</label>
                            <textarea id="question" rows="6" class="form-control " name="question" required placeholder="Please enter question."></textarea>
                        </div>
                       
                        <div class="form-group ">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="questiontype" value="1" /> Exercise Question
                                </label>
                            </div>
                        </div>
                        <!-- 
                        <div class="form-group ">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="upload_media form-check-input" type="checkbox" name="upload_media" value="1" onchange="valueChanged()" /> Upload Media as Answer
                                </label>
                            </div>
                        </div> 
                        -->
                        <div class="form-group">
                            <label class="form-control-label">Answer</label>
                            <textarea class="form-control" rows="6" id="answer" name="answer" required placeholder="Please enter answer."></textarea>
                        </div>


                        <div class="form-group">
                            <label class="control-label">Media</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="media" value="upload_media" id="media_option1" checked="checked">Upload media
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="media" value="external_media" id="media_option2">External media
                                </label>
                            </div>
                        </div>


                        <div class="form-group" id="upload_media">
                            <label class="form-control-label">Upload</label>
                            <input type="file" class="form-control" name="upload" accept="image/*,video/*">
                            <p id="showUploadMessage">Max Upload Size: 10 MB </p>
                        </div>

                        <div class="form-group" id="external_media">
                            <label class="form-control-label">Upload</label>
                            <input type="text" class="form-control" name="external_media">
                        </div>





                        <div class="form-group">
                            <label class="form-control-label">Clue</label>
                            <input id="clue" type="text" class="form-control " name="clue" required placeholder="Please enter clue.">
                        </div>
                        <div class="form-group">
                            <label for="comp">Topic</label>
                            <select name="topic_id" id="topic_id" class="form-control " required>
                                <option value="">--- Select Topic ---</option>
                                <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->id); ?>"><?php echo e($data->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="comp">Level</label>
                            <select name="level" id="topic_id" class="form-control " required>
                                <option value="">--- Select Level ---</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php if(Auth::check()): ?>
                <div class="tile-footer text-right ">
                    <a href="<?php echo e(route('questions_answers')); ?>" class="btn btn-default"><?php echo app('translator')->get('general.cancel'); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('general.save'); ?></button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('form').submit(function(event) {
        if ($(this).hasClass('submitted')) {
            event.preventDefault();
        } else {
            $(this).find(':submit').html('<i class="fa fa-spinner fa-spin"></i>');
            $(this).addClass('submitted');
        }
    });
    $("#upload").hide();

    function valueChanged() {
        if ($('.upload_media').is(":checked")) {
            $("#answer").hide();
            $("#upload").show();
            $("#showUploadMessage").show();
        } else {
            $("#answer").show();
            $("#upload").hide();
            $("#showUploadMessage").hide();
        }
    }
    $('.form-check-label').click(function() {
        $("#upload").attr("required", "true");
        $('#answer').removeAttr('required');
    });




    $("#upload_media").show();
    $("#external_media").hide();

    $("#upload_media").attr("disabled", false);
    $("#external_media").attr("disabled", true);




    // upload media
    $('#media_option1').click(function() {

        $("#upload_media").show();
        $("#external_media").hide();
    });
    // external media
    $('#media_option2').click(function() {

        $("#upload_media").hide();
        $("#external_media").show();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/question-answers/add.blade.php ENDPATH**/ ?>