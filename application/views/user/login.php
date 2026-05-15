<div class="login-box">
  <div class="login-logo"><a href="#"><b><?php echo SITE_NAME; ?></b></a></div>
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php if(isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
    <?php echo form_open('user/login'); ?>
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    <?php echo form_close(); ?>
  </div>
</div>
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
