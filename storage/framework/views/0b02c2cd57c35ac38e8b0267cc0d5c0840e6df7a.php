<?php $__env->startSection( 'content' ); ?>
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">All Articles</li>
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
            
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Title </th>
                             
                               <th>Topic </th>
                             <th>Tribe </th>
                             <th>Date </th>
                           
                            <th>Total Comments</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr >
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                 <td>
                                    <?php echo e($row->article_title); ?>

                                </td>

 <td>
                                    <?php echo e($row->topicTitle); ?>

</td>
                                     <td>
                                    <?php echo e($row->tribeTitle); ?>

                                </td>

                                
                                
                                    <td>
                                    <?php echo e($row->created_at); ?>

                                </td>

                                <td>
                                    

                                    <?php
$count = DB::table('discussions')->where('discussions.article_id' , $row->id)->join('users' , 'users.id' , '=' , 'discussions.user_id')->count();
         echo $count;                      
         $comments_link = '/article_comments/'.$row->id; ?></td>

                                <td>
                                    <a class=" btn btn-sm btn-dark" href='<?php echo e($comments_link); ?>'  style="color:white;"><i class="fa fa-eye mr-1"  aria-hidden="true"></i> Manage Comments </a>

                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    

    <script>

        $(document).ready(function() {
            $('#example').DataTable( {
                "order": [[ 0, "asc" ]]
            } );
        } );

    </script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>