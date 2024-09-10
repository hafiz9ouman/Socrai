

<?php $__env->startSection('content'); ?>





    <section class="dashboard">
    <div class="row m-0">
  
        <div class="col-md-12 p-0">
          <div class="detail_section" data-aos="zoom-in" data-aos-duration="1000">
            

             <div class="settings">
    <div class="container">

        <div class="row justify-content-md-center">

            <div class="col-md-12">

                <div class="fa_title">

                    <h2>Two Factor Authentication</h2>


                    <div class="fa_detail">

                      <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>




                        <?php if(session('error')): ?>

                            <div class="alert alert-danger">

                                <?php echo e(session('error')); ?>


                            </div>

                        <?php endif; ?>

                        <?php if(session('success')): ?>

                            <div class="alert alert-success">

                                <?php echo e(session('success')); ?>


                            </div>

                        <?php endif; ?>



                        <?php if($data['user']->loginSecurity == null): ?>

                            <form class="form-horizontal" method="POST" action="<?php echo e(route('generate2faSecret')); ?>">

                                <?php echo e(csrf_field()); ?>


                                <div class="fa_btn">

                                    <button type="submit" class="btn btn-block btn-dark">

                                        Generate Secret Key to Enable 2FA

                                    </button>

                                </div>

                            </form>

                        <?php elseif(!$data['user']->loginSecurity->google2fa_enable): ?>

                            <p class="fa_scan_code">1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: <code><?php echo e($data['secret']); ?></code></p>
                            <br/>

                            <img src="<?php echo e($data['google2fa_url']); ?>" alt="">

                            <br/><br/>

                            <p>2. Enter the pin from Google Authenticator app</p>

                            <form class="form-horizontal" method="POST" action="<?php echo e(route('enable2fa')); ?>">

                                <?php echo e(csrf_field()); ?>


                                <div class="form-group<?php echo e($errors->has('verify-code') ? ' has-error' : ''); ?>">

                                    <label for="secret" class="control-label">.Authenticator Code</label>

                                    <input id="secret" type="password" class="form-control col-md-4" name="secret" required>

                                    <?php if($errors->has('verify-code')): ?>

                                        <span class="help-block">

                                        <strong><?php echo e($errors->first('verify-code')); ?></strong>

                                        </span>

                                    <?php endif; ?>

                                </div>

                                <button type="submit" class="btn btn-success enable_btn">

                                   Enable 2FA

                                </button>

                            </form>

                        <?php elseif($data['user']->loginSecurity->google2fa_enable): ?>

                            <!-- <div class="alert alert-success">

                                2FA is currently <strong>enabled</strong> on your account.

                            </div>

                            <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p> -->

                            <!-- <form class="form-horizontal" method="POST" action=""> -->

                                <?php echo e(csrf_field()); ?>


                                <!-- <div class="form-group<?php echo e($errors->has('current-password') ? ' has-error' : ''); ?>">

                                    <label for="change-password" class="control-label">Current Password</label>

                                        <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>

                                        <?php if($errors->has('current-password')): ?>

                                            <span class="help-block">

                                        <strong><?php echo e($errors->first('current-password')); ?></strong>

                                        </span>

                                        <?php endif; ?>

                                </div> -->

                                <!-- <button type="submit" class="btn btn-primary ">Disable 2FA</button> -->

                            <!-- </form> -->

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>
             </div>

          </div>
       </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'layouts.2factorlayout' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>