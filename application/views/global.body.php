
</head>

<body class="twui">

  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="<?php echo Url::app_url(); ?>">Twui</a>
        <div class="nav-collapse">
          <ul class="nav">
            <li <?php if (Controller::current(true) == 'test'): ?>class="active"<?php endif; ?>>
              <a href="<?php echo Url::app_url(); ?>test">Test</a>
            </li>
            <li <?php if (Controller::current(true) == 'about'): ?>class="active"<?php endif; ?>>
              <a href="<?php echo Url::app_url(); ?>about">About</a>
            </li>
          </ul>
          <?php if(isset($_SESSION['user'])): ?>
          <p class="navbar-text pull-right">Logged in as <a href="<?php echo Url::app_url(); ?>profile">username</a></p>
          <li class="divider-vertical"></li>
          <ul class="nav pull-right">
            <li><a href="<?php echo Url::app_url(); ?>">Sign Out &raquo;</a></li>
          </ul>
          <?php else: ?>
          <ul class="nav pull-right">
            <?php if (isset($_GET['url'])): ?>
            <li><a href="<?php echo base64_decode($_GET['url']); ?>">&laquo; Back</a></li>
            <?php else: ?>
            <li><a href="<?php echo Url::app_url(); ?>authentication?url=<?php echo base64_encode(Url::current_url()); ?>">Sign In &raquo;</a></li>
            <?php endif; ?>
          </ul>
          <?php endif; ?>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>

