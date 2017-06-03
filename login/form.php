<p class="form-title">Sign In</p>
<div class="errors">
  <span class="errors"><?php echo $error; ?></span>
</div>
<form class="login" method="post">
  <input id="username" name="username"  type="text" placeholder="Username" />
  <input id="password" name="password" type="password" placeholder="Password" />
  <input type="submit" name="submit" value="Sign In" class="btn btn-success btn-sm" />
  <div class="remember-forgot">
      <div class="row">
          <div class="col-md-6">
              <div class="checkbox">
                  <label>
                      <input type="checkbox" />
                      Remember Me
                  </label>
              </div>
          </div>
          <div class="col-md-6 forgot-pass-content">
              <a href="javascript:void(0)" class="forgot-pass">Forgot Password</a>
          </div>
      </div>
  </div>
</form>
