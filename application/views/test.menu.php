
  <ul class="nav nav-tabs twui-submenu">
    <li <?php if (Controller::current()->action() == 'index'): ?>class="active"<?php endif; ?>>
      <a href="<?php echo Url::app_url();?>test">Dashboard</a>
    </li>
    <li <?php if (Controller::current()->action() == 'play'): ?>class="active"<?php endif; ?>>
      <a href="<?php echo Url::app_url();?>test/play">Play</a>
    </li>
    <li <?php if (Controller::current()->action() == 'record'): ?>class="active"<?php endif; ?>>
      <a href="<?php echo Url::app_url();?>test/record">Record</a>
    </li>
    <li <?php if (Controller::current()->action() == 'create'): ?>class="active"<?php endif; ?>>
      <a href="<?php echo Url::app_url();?>test/create">Create</a>
    </li>
  </ul>
