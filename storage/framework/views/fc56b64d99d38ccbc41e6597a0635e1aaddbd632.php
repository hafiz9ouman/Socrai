<?php $__env->startSection('title', 'Edit Questions Answers'); ?>

<?php $__env->startSection( 'content' ); ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Question and Answers</h1>
        <p>Edit Question and Answers</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
        </li>
        <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="<?php echo e(url('/questions_answers')); ?>">All Questions Answers</a>
        </li>
        <li class="breadcrumb-item">Edit Questions Answers</li>
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
            <h3 class="tile-title">Edit Questions & Answer</h3>
            <form class="form-horizontal" method="POST" action="<?php echo e(route('update.question')); ?>" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-control-label">Question</label>
                            <textarea id="question" class="form-control" rows="6" name="question" required><?php echo e($data->question); ?></textarea>
                        </div>

                        

                        <?php
                        $image_type = array(
							'png',
							'PNG',
                            'jpeg',
							'JPEG',
							'jpg',
							'JPG',
                            'pjpeg',
							'PJPEG',
                            'gif',
							'GIF'
                        );

                        $video_type = array('mp4');
                        $audio_type = array('mp3');
                        ?>

                        <!-- ahmadcode   show dropdown on check -->
                        <?php if($data->type == 0): ?>
                        <div class="form-group ">
                            <div class="form-check">
                                <input class="coupon_question form-check-input" type="checkbox" name="check_exercise_question" <?php if($attach_flag !=null): ?>checked="true" <?php endif; ?> value="1" />
                                <label for="coupon_question"> Add Question to exercise</label>
                            </div>
                        </div>
                        <?php endif; ?>

                        <fieldset class="answerr">
                            <label for="coupon_field">Select Exercise:</label>
                            <select type="text" name="exercise_question" class="form-control" id="coupon_field" />
                            <option value=null> <?php if($attach_flag != null): ?> <?php echo $attach_flag->question ?> <?php endif; ?></option>
                            <?php $__currentLoopData = $exercise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($datum->id); ?> "><?php echo $datum->question ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </fieldset>
                        <!-- end ahmad cpde -->
                        <div class="form-group">
                            <label class="form-control-label">Answer</label>
                            <textarea class="form-control" rows="6" id="answer" name="answer" placeholder="Please enter answer." required><?php echo e($data->answer); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Media</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="media" value="upload_media" id="media_option1" <?php echo e(( $data->media_type != "external" )? 'checked=checked': ''); ?>>Upload media
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="media" value="external_media" id="media_option2" <?php echo e(($data->media_type == "external" )? 'checked=checked': ''); ?>>External media
                                </label>
                            </div>
                        </div>

                        <!-- upload media -->
                        <div class="form-group" id="upload_media">
                            <label class="form-control-label">Upload</label>
                            <input type="file" class="form-control" name="upload" accept="image/*,video/*">
                            <p id="showUploadMessage">Max Upload Size: 10 MB </p>
                        </div>
                        <!-- external media -->
                        <div class="form-group" id="external_media">
                            <label class="form-control-label">Upload</label>

                            <?php if( $data->media_type == "external"): ?>
                            <input type="text" class="form-control" name="external_media" value="<?php echo e($data->media); ?>">
                            <?php else: ?>
                            <input type="text" class="form-control" name="external_media" value="">
                            <?php endif; ?>
                        </div>


                        <div class="form-group" id="upload_media_image">
                            <?php if( $data->media_type != "external" && in_array($data->media_type, $image_type)): ?>
                                <img src="<?php echo e(url($data->media)); ?>" width="100" height="100">
                            <?php elseif( $data->media_type != "external" && in_array( $data->media_type, $video_type) ): ?>
                            <video controls poster="<?php echo e(url('public/play.png')); ?>" width="320" height="240">
                                <source src="<?php echo e(url($data->media)); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <?php elseif( $data->media_type != "external" && in_array( $data->media_type, $audio_type) ): ?>
                            <audio controls>
                                <source src="<?php echo e(url($data->media)); ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <?php elseif( $data->media_type == "external"): ?>
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="500" height="300" src="<?php echo e($data->media); ?>"></iframe>
                            <?php endif; ?>
                        </div>




                        <div class="form-group">
                            <label class="form-control-label">Clue</label>
                            <input id="clue" type="text" class="form-control " value="<?php echo e($data->clue); ?>" name="clue" required>
                        </div>

                        <div class="form-group ">
                            <label for="comp">Topic</label>
                            <select name="topic_id" id="topic_id" class="form-control " required>
                                <option value="">--Select Topic--</option>
                                <?php $__currentLoopData = $data->topic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($xc->id); ?>" <?php if($data->current_topic == $xc->title): ?> selected="true" <?php endif; ?> ><?php echo e($xc->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>


                        <div class="form-group ">
                            <label for="comp">Level</label>
                            <select name="level" id="topic_id" class="form-control " required>
                                <option value=""> Select Level </option>
                                <option value="1" <?php if($data->level == 1): ?> selected="true" <?php endif; ?>>1</option>
                                <option value="2" <?php if($data->level == 2): ?> selected="true" <?php endif; ?>>2</option>
                                <option value="3" <?php if($data->level == 3): ?> selected="true" <?php endif; ?>>3</option>
                            </select>
                        </div>



                    </div>

                </div>

                <input type="hidden" class="form-control" name="id" value="<?php echo e($id); ?>">

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
    $(document).ready(function() {

        <?php if($attach_flag != null): ?>
        $(".answerr").show();
        <?php else: ?>
        $(".answerr").hide();

        <?php endif; ?>


        $(".coupon_question").click(function() {
            if ($(this).is(":checked")) {
                $(".answerr").show();
            } else {
                $(".answerr").hide();
            }
        });

    });


    $('.form-check-label').click(function() {
        $("#upload").attr("required", "true");
        $('#answer').removeAttr('required');
    });

    // media radio 
    <?php if($data->media_type == "external"): ?>

    $("#external_media").show();
    $("#upload_media").hide();
    $("#upload_media_image").hide();

    <?php else: ?>

    $("#external_media").hide();
    $("#upload_media").show();
    $("#upload_media_image").show();

    <?php endif; ?>


    // upload media
    $('#media_option1').click(function() {

        $("#upload_media").show();
        $("#external_media").hide();
        $("#upload_media_image").show();
    });
    // external media
    $('#media_option2').click(function() {

        $("#upload_media").hide();
        $("#external_media").show();
        $("#upload_media_image").hide();
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/question-answers/edit.blade.php ENDPATH**/ ?>