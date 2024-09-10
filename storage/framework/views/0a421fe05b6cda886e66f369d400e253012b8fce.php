<header class="app-header">

  <a style="font-family: none;" class="app-header__logo  " href="https://dev.socrai.com/admin">
        <img src="<?php echo e(asset('sucrai/assets/images/logo.png')); ?>" class="img-fluid">
   </a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
     <?php $check_2fa = DB::table('login_securities')->where('user_id' , auth()->user()->id)->pluck('google2fa_enable')->first();

      ?>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
    			
          
          <?php if( $check_2fa == null || $check_2fa == 0  ): ?>
    			 <li><a class="dropdown-item" href="<?php echo e(url('/2fa')); ?>"><i class="fa fa-sign-out fa-lg"></i>Enable 2fa</a></li>
          <?php endif; ?>
          <?php if($check_2fa == 1): ?>
           <li><a class="dropdown-item" href="<?php echo e(url('/2fa/disable')); ?>"><i class="fa fa-sign-out fa-lg"></i>Disable 2fa</a></li>
           <?php endif; ?>
          
            <li><a class="dropdown-item" href="<?php echo e(url('/update-password/'.auth()->user()->id)); ?>"><i class="fa fa-sign-out fa-lg"></i>Change Password</a></li>

          <li><a class="dropdown-item" href="<?php echo e(url('logout')); ?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
<?php /**PATH F:\xampp\htdocs\socrai.com8\socrai.com\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>