<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  
  <?php if(Auth::user()->image!=""): ?>

  <a href="/update-profile/<?php echo e(auth()->user()->id); ?>"><div class="app-sidebar__user"><img class="app-sidebar__user-avatar" style="width: 83px; height: 83px;" src="/public/images/sucrai/<?php echo e(Auth::user()->image); ?>" alt="User Image">
    <div>
    </a>
      <?php else: ?>
     
      <div class="app-sidebar__user">

        <img class="app-sidebar__user-avatar" src="/public/images/sucrai/abc.png" alt="User Image" style="width: 83px; height: 83px;">
        


        <div>
          <?php endif; ?>
          <p class="app-sidebar__user-name"><?php if((Auth::user()->user_role) == '2'): ?> <?php echo e('Socrai Leader'); ?> <?php endif; ?></p>
          <p class="app-sidebar__user-name"><?php if((Auth::user()->user_role) == '1'): ?> <?php echo e('Socrai Admin'); ?> <?php endif; ?></p>
          <p class="app-sidebar__user-name"><?php echo e(Auth::user()->name); ?></p>
          <p class="app-sidebar__user-designation"><?php echo e(Auth::user()->email); ?></p>
        </div>
      </div>
      <ul class="app-menu">

        <?php if((Auth::user()->user_role) != 3): ?>


        <?php if((Auth::user()->user_role) == '1'): ?>
            <li><a class="app-menu__item <?php if (Request::segment(1) == "site_admin") echo "active"; ?>" href="<?php echo e(url('site_admin')); ?>"> <i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label"> Manage Site Admins</span></a></li>


        <?php endif; ?>   


        <li><a class="app-menu__item <?php if (Request::segment(1) == "join_requests") echo "active"; ?>" href="<?php echo e(url('join_requests')); ?>"> <i class="fa fa-bell" aria-hidden="true"></i> <span class="app-menu__label"> See Join Requests</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "users") echo "active"; ?>" href="<?php echo e(url('users')); ?>"> <i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label">  Manage Users</span></a></li>
    

        <li><a class="app-menu__item <?php if (Request::segment(1) == "tribes") echo "active"; ?>" href="<?php echo e(url('tribes')); ?>"><i class="fa fa-wrench" aria-hidden="true"> </i>
<span class="app-menu__label"> Manage Tribes</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "tribeleader") echo "active"; ?>" href="<?php echo e(url('tribeleader')); ?>"><i class="fa fa-user-circle-o" aria-hidden="true"> </i>
<span class="app-menu__label"> Tribe Leaders</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "socraileader") echo "active"; ?>" href="<?php echo e(url('socraileader')); ?>"><i class="fa fa-check-circle" aria-hidden="true"> </i>
<span class="app-menu__label"> Socrai Leaders</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "questions_answers") echo "active"; ?>" href="<?php echo e(url('questions_answers')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"> </i><span class="app-menu__label">Questions Answers</span></a></li>
        
        <li><a class="app-menu__item <?php if (Request::segment(1) == "topics") echo "active"; ?>" href="<?php echo e(url('topics')); ?>"><i class="fa fa-grav" aria-hidden="true">  </i><span class="app-menu__label"> Topics</span></a></li>
        <li><a class="app-menu__item <?php if (Request::segment(1) == "/media/home") echo "active"; ?>" href="<?php echo e(url('/media/home')); ?>"><i class="fa fa-file-image-o" aria-hidden="true"> </i><span class="app-menu__label"> Add Media</span></a></li>
        <?php endif; ?>

          <?php if((Auth::user()->user_role) == '1'): ?>
            <li><a class="app-menu__item <?php if (Request::segment(1) == "pages") echo "active"; ?>" href="<?php echo e(url('pages')); ?>"> <i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label"> Manage Pages</span></a></li>
          <?php endif; ?> 

        <?php if((Auth::user()->user_role) == 3): ?>
        <li><a class="app-menu__item <?php if (Request::segment(1) == "tribesleader") echo "active"; ?>" href="<?php echo e(url('tribesleader')); ?>"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Tribe members</span></a></li>
        <?php endif; ?>
        
        <li><a href="<?php echo e(url('discussions')); ?>" class="app-menu__item" href="javascript:;"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Discussions</span></a></li>


        <li><a class="app-menu__item" href="<?php echo e(url('logout')); ?>"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span></a></li>

      </ul>
    </div>
  </div>
</aside>