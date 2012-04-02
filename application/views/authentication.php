<?php include VIEWPATH.'global.head.php'; ?>

  <title>Authenticate yourself</title>

<?php include VIEWPATH.'global.body.php'; ?>

  <div class="container twui-content">
    <div class="row">
      <div class="span4 offset4">

        <h1>Authenticate yourself</h1>

        <form class="well" method="POST" id="authentication">
          <label for="username">Login</label>
          <input type="text" name="username" id="username" />
          <span class="help-inline">Username or mail address</span>
          <label for="password">Password</label>
          <input type="password" name="password" id="password" />
          <br/>
          <button type="submit" class="btn btn-primary">Se connecter &raquo;</button>
        </form>

      </div>
    </div>
  </div> <!-- /container-fluid -->

<?php include VIEWPATH.'global.foot.php'; ?>
