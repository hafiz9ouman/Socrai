<!DOCTYPE html>
<html lang="en">
  <?php echo $__env->make('admin.layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <?php echo $__env->make('admin.layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Sidebar menu-->
    <?php echo $__env->make('admin.layouts.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <main class="app-content">
      <?php echo $__env->yieldContent('content'); ?>
    </main>
	  <?php echo $__env->make('admin.layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Essential javascripts for application to work-->
    
    
  </body>
</html>
