

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
            <li class="breadcrumb-item">Add User</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile ">
                <h3 class="tile-title ">Add User</h3>
                <form class="form-horizontal" id="form" method="POST" action="/tribe_user_store" enctype="multipart/form-data">

                    <div class="row ">


                    <?php echo e(csrf_field()); ?>

                       <!--  <div class="col-sm-6 col-md-4 ">
                            <label for="comp">Users</label>
                            
                            <select name="user_id" id="topic_id" class="form-control "  required >
                                <option value="">--- Select User  ---</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                       
                        </div> -->
                        <div class="align_input" style="    width: 100%;display: flex;justify-content: flex-end; margin-bottom: 10px;">
                        <input style="    max-width: 20%;    margin-right: 15px;" class="form-control" id="myInput" type="text" placeholder="Search..">
                            
                        </div>

                        <table  class="table table-hover">
                                <thead>
                                       <tr>
                                                    <th>Image</th>
                                                    <th> Name </th>
                                                    <th>E-mail</th>
                                                    <th>Select User</th>

                                                    
                                       </tr>
                                </thead>
                                <tbody id="myTable">
                                         <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                                
                                               
                                                <td>
                                            <?php if($data->image == ''): ?>
                                            <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="/images/sucrai/abc.png " style=" height: 70px !important;width: 68px; border-radius: 30px;">
                                            <?php else: ?>
                                            <img class=" img-circle img-size-32 mr-2 round_img" height="15%" src="/images/sucrai/<?php echo e($data->image); ?> " style=" height: 70px !important;width: 68px; border-radius: 30px;">
                                            <?php endif; ?>        
                                        </td>

                                                <td><?php echo e($data->name); ?></td>
                                                <td style="text-transform: none !important;"><?php echo e($data->email); ?></td>
                                                 <td>
                                                    <div class="form-check ">
                                                        <input type="checkbox"  value="<?php echo e($data->id); ?>"     name="user_id[]" class="form-check-input roomselect" id="<?php echo e($data->id); ?>">
                                                      </div>
                                                </td>


                                         </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                

                                </tbody>

                        </table>

                       
                    <input type="hidden" name="id" value="<?php echo e($id); ?>">
                    </div>
                    <?php if(Auth::check()): ?>
                        <div class="tile-footer text-right " >
                            <a href="<?php echo e(route('tribes')); ?>" class="btn btn-default"><?php echo app('translator')->get('general.cancel'); ?></a>
                            <button type="submit" id="subm" class="btn btn-primary"><?php echo app('translator')->get('general.save'); ?></button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>

        </div>
    </div>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
    $('#myInput').on('keypress', function(e) {
        return e.which !== 13;
    });

});

</script>
<script type="text/javascript">
    $("#subm").click(function(e){
        if($(".roomselect:checked").length == 0){
            e.preventDefault();
            alert('Please select atleast 1 user to proceed'); 
        }
    });
</script>


<?php $__env->stopSection(); ?>



<?php echo $__env->make( 'admin.layouts.app' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/tribe/add_user.blade.php ENDPATH**/ ?>