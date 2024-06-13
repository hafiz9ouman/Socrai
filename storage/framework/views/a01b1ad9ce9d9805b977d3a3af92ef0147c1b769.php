<!DOCTYPE html>
<html lang="en">
  <?php echo $__env->make('admin.layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Sidebar menu-->
    <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main class="app-content">
      <?php echo $__env->yieldContent('content'); ?>
    </main>
	  <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Essential javascripts for application to work-->
    
    
  </body>
</html>
<?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>