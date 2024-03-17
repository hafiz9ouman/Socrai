<html><body>
                <img style="background:black;" src="<?php echo e(env('APP_URL')); ?>/sucrai/assets/images/logo.png" alt="Password Change Request" />
                <table rules="all" style="border-color: #666;" cellpadding="10">
                <tr style='background: #eee;'><td><strong>Name:</strong> </td><td><?php echo e(strip_tags($name)); ?></td></tr>
                <tr><td><strong>Email:</strong> </td><td><?php echo e(strip_tags($email)); ?></td></tr>


                    <tr><td><strong></strong> </td><td>New Password : <?php echo e(strip_tags( $password)); ?>  </td></tr>

                
                </table>
                </body></html>