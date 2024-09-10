
<?php $__env->startSection( 'content' ); ?>
    <style>
        .dule-btns{
            display: flex;
        }
        body{
  margin:20px;
  font-family: Helvetica, Arial, sans-serif;
}
.pull-right{
  float:right;
}
.pull-left{
  float:left;
}
#fbcomment{
  background:#fff;
  border: 1px solid #dddfe2;
  border-radius: 3px;
  color: #4b4f56;
  padding:50px;
}
.header_comment{
    font-size: 14px;
    overflow: hidden;
    border-bottom: 1px solid #e9ebee;
    line-height: 25px;
    margin-bottom: 24px;
    padding: 10px 0;
}
.sort_title{
  color: #4b4f56;
}
.sort_by{
  background-color: #f5f6f7;
  color: #4b4f56;
  line-height: 22px;
  cursor: pointer;
  vertical-align: top;
  font-size: 12px;
  font-weight: bold;
  vertical-align: middle;
  padding: 4px;
  justify-content: center;
  border-radius: 2px;
  border: 1px solid #ccd0d5;
}
.count_comment{
  font-weight: 600;
}
.body_comment{
    padding: 0 8px;
    font-size: 14px;
    display: block;
    line-height: 25px;
    word-break: break-word;
}
.avatar_comment{
  display: block;
}
.avatar_comment img{
  height: 48px;
  width: 48px;
}
.box_comment{
    display: block;
    position: relative;
    line-height: 1.358;
    word-break: break-word;
    border: 1px solid #d3d6db;
    word-wrap: break-word;
    background: #fff;
    box-sizing: border-box;
    cursor: text;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 16px;
    padding: 0;
}
.box_comment textarea{
    min-height: 40px;
    padding: 12px 8px;
    width: 100%;
    border: none;
    resize: none;
}
.box_comment textarea:focus{
  outline: none !important;
}
.box_comment .box_post{
    border-top: 1px solid #d3d6db;
    background: #f5f6f7;
    padding: 8px;
    display: block;
    overflow: hidden;
}
.box_comment label{
  display: inline-block;
  vertical-align: middle;
  font-size: 11px;
  color: #90949c;
  line-height: 22px;
}
.box_comment button{
  margin-left:8px;
  background-color: #4267b2;
  border: 1px solid #4267b2;
  color: #fff;
  text-decoration: none;
  line-height: 22px;
  border-radius: 2px;
  font-size: 14px;
  font-weight: bold;
  position: relative;
  text-align: center;
}
.box_comment button:hover{
  background-color: #29487d;
  border-color: #29487d;
}
.box_comment .cancel{
    margin-left:8px;
    background-color: #f5f6f7;
    color: #4b4f56;
    text-decoration: none;
    line-height: 22px;
    border-radius: 2px;
    font-size: 14px;
    font-weight: bold;
    position: relative;
    text-align: center;
  border-color: #ccd0d5;
}
.box_comment .cancel:hover{
    background-color: #d0d0d0;
    border-color: #ccd0d5;
}
.box_comment img{
  height:16px;
  width:16px;
}
.box_result{
  margin-top: 24px;
}
.box_result .result_comment h4{
  font-weight: 600;
  white-space: nowrap;
  color: #365899;
  cursor: pointer;
  text-decoration: none;
  font-size: 14px;
  line-height: 1.358;
  margin:0;
}
.box_result .result_comment{
  display:block;
  overflow:hidden;
  padding: 0;
}
.child_replay{
    border-left: 1px dotted #d3d6db;
    margin-top: 12px;
    list-style: none;
    padding:0 0 0 8px
}
.reply_comment{
    margin:12px 0;
}
.box_result .result_comment p{
  margin: 4px 0;
  text-align:justify;
}
.box_result .result_comment .tools_comment{
  font-size: 12px;
  line-height: 1.358;
}
.box_result .result_comment .tools_comment a{
  color: #4267b2;
  cursor: pointer;
  text-decoration: none;
}
.box_result .result_comment .tools_comment span{
  color: #90949c;
}
.body_comment .show_more{
  background: #3578e5;
  border: none;
  box-sizing: border-box;
  color: #fff;
  font-size: 14px;
  margin-top: 24px;
  padding: 12px;
  text-shadow: none;
  width: 100%;
  font-weight:bold;
  position: relative;
  text-align: center;
  vertical-align: middle;
  border-radius: 2px;
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
             <li class="breadcrumb-item"><a href="<?php echo e(url('/tribes')); ?>">Manage Tribes</a></li>
            <li class="breadcrumb-item">Article "<?php echo e($article_data->article_title); ?>" comments</li>
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
                 <?php    $error_mess = explode(',',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   
                                  
                                <div class="alert alert-warning" style="width: 100%">
                                            <?php echo e($errmess); ?>

                                        </div>

                             <?php
                  }
              }

         ?>
                <h3 class="tile-title">Discusion of article: <?php echo e($article_data->article_title); ?>

                   </h3>
                <div class="">
                    <body>
    <div class="container">
        <div class="col-md-12" id="fbcomment">
            <div class="header_comment">
                <div class="row">

                      <div class="art_image w-100 text-center"> <img src="<?php echo e(url('public/images/sucrai/'.$article_data->image)); ?>" class="img-fluid" style="width: 500px;"> </div>
                    <div class="col-md-6 text-left">

                      <span class="count_comment"><?php echo e(DB::table('discussions')->where('discussions.article_id' , $article_data->id)->join('users' , 'users.id' , '=' , 'discussions.user_id')->count()); ?> Comments</span>
                    </div>
                   
                </div>
            </div>

            <div class="body_comment">
                
                <div class="row">
                    <ul id="list_comment" class="col-md-12">
                        <!-- Start List Comment 1 -->
                                    
                        <?php $__currentLoopData = $root_comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $root): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                    
                        <li class="box_result row">
                            <div class="avatar_comment col-md-1">
                            	<?php $image='abc.png';  if($root->image){$image = $root->image;}  ?>
                                <img src="<?php echo e(url('public/images/sucrai/'.$image)); ?>" alt="avatar"/>
                            </div>
                            <div class="result_comment col-md-11">
                                <h4><?php echo e($root->name); ?></h4>
                                <p><?php echo e($root->comment); ?></p>
                                <div class="tools_comment">
                                    
                                    
                                    
                                    
                                    <i class="fa fa-thumbs-o-up"></i> <span class="count"><?php echo e($root->total_likes); ?></span> 
                                    <span aria-hidden="true"> · </span>
                                    <span class="ml-2"><?php echo e(\Carbon\Carbon::parse($root->created_at)->diffForHumans()); ?></span>
                                    <a class="delete" data-id="<?php echo e($root->id); ?>"><span class="ml-2 delete" style="color: red;"><i class="fa fa-trash delete" style="color: red;" aria-hidden="true"></i> Delete</span></a>
                                </div>

                                           
                            <?php if($root->child != null): ?>
                                <?php $__currentLoopData = $root->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <ul class="child_replay">
                                    <li class="box_reply row">
                                        <div class="avatar_comment col-md-1">
                                            <?php $image='abc.png';  if($child->image){$image = $child->image;}  ?>
                                                       <img src="<?php echo e(url('public/images/sucrai/'.$image)); ?>" alt="avatar"/>
                                        </div>
                                         <div class="result_comment col-md-11">
                                            <h4><?php echo e($child->name); ?></h4>
                                            <p><?php echo e($child->comment); ?></p>
                                            <div class="tools_comment">
                                                
                                                
                                                
                                                
                                                <i class="fa fa-thumbs-o-up"></i> <span class="count"><?php echo e($child->total_likes); ?></span> 
                                                <span aria-hidden="true"> · </span>
                                                <span class="ml-2"><?php echo e(\Carbon\Carbon::parse($child->created_at)->diffForHumans()); ?></span>
                                                
                                                <a class="delete"  data-id="<?php echo e($child->id); ?>"><span class="ml-2 delete" style="color: red;"><i class="fa fa-trash delete" style="color: red;" aria-hidden="true"></i> Delete</span></a>


                                            </div>
                                            <ul class="child_replay"></ul>
                                        </div>
                                    </li>
                                </ul>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>


                            </div>
                        </li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        
                      
                    </ul>
                
                </div>
            </div>
        </div>
    </div>
</body>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="div_dbReadMany" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content modal-info">
            <div class="modal-header">
                
            </div>
            <div class="modal-body">
                <form class="form">
                <input type="text" value="askjdhakjhd askdh aksdh ka hdjka hd">
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success save" >Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Article Model -->


<div id="exampleModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="tribe_title"></h4>
        
        
      </div>
      <div class="modal-body">
         <table style="width: 100% !important" class="table table-bordered table-responsive">
             <thead>
                 <tr>
                     
                     <th>Article name</th>
                     <th>Number of comments</th>
                     
                     <th>See details</th>
                 </tr>
             </thead>
             <tbody id="data_show"></tbody>
         </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                title: "Do you want to delete this comment",
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
                        url: '<?php echo url("tribe/article/comment/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "<?php echo app('translator')->getFromJson('Comment Deleted Successfully'); ?>", '', 'success' )
                            setTimeout( function () {
                                location.reload();
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>
    <script type="text/javascript">
        function myFun(tribe_id){
                    var form_data = {

                // course_id: course_id,
                tribe_id: tribe_id,

            };
       $.ajax({

                        type: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                        },

                        url: '<?php echo url("tribe/get/articles"); ?>',

                        data: form_data,

                        success: function ( msg ) {

                           $('#data_show').html(msg);

                           

                        }

                    });

        }
    </script>
    <style>
        .sweet-alert h2 {
            font-size: 1.3rem !important;
        }

        .sweet-alert .sa-icon {
            margin: 30px auto 35px !important;
        }
    </style>


    <script>

        $(document).ready(function() {
            $('#example').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
        } );

    </script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'admin.layouts.app' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>