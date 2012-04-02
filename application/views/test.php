<?php include(VIEWPATH.'global.head.php'); ?>

 <title>Test</title>

<?php include(VIEWPATH.'global.body.php'); ?>

  <?php if (is_file(VIEWPATH.'test.menu.php')): ?>
    <?php include(VIEWPATH.'test.menu.php'); ?>
  <?php endif; ?>

  <div class="container-fluid twui-content">
    <div class="row-fluid">

      <?php include(VIEWPATH.'test.'.Controller::current()->action().'.php'); ?>

    </div><!--/row-->
  </div><!--/.fluid-container-->

<?php include(VIEWPATH.'global.foot.php'); ?>
