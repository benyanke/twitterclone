<div id="login">
   <form class="form-signin" action="<?php echo $this->viewdata['login-submit']; ?>" method="post">
      <h2 class="form-signin-heading">TwitterClone</h2>
      <input autofocus="" class="form-control" name="username" placeholder="Username" required="" type="text">
      <input class="form-control" name="password" placeholder="Password" required="" type="password">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <?php if (isset($this->viewdata['login-error']) && strlen($this->viewdata['login-error']) > 0) { ?>
          <span class="error alert alert-warning"><?php echo $this->viewdata['login-error']; ?></span>
      <?php } ?>
   </form>
</div> <!-- End #login -->
