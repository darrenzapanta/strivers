

  <div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <?php echo form_open('VerifyLogin'); ?>
            <h1>STRIVERS LOGIN</h1>
            <div>
              <input class="form-control" name="username" id="username" type="text" placeholder="Username" class="validate">
            </div>
            <div>
              <input class="form-control" name="password" id="password" type="password" placeholder="Password" class="validate">
            </div>
            <div>
              <button class="btn btn-default submit" type="submit"  >Log in</button>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

              <p class="change_link">New to site?
                <a href="#toregister" class="to_register"> Create Account </a>
              </p>
              <div class="clearfix"></div>
              <br />
            </div>
          </form>
          <?php echo validation_errors(); ?>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
      <div id="register" class="animate form">
        <section class="login_content">
          <form>
            <h1>Create Account</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <a class="btn btn-default submit" href="index.html">Register</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

              <p class="change_link">Already a member ?
                <a href="#tologin" class="to_register"> Log in </a>
              </p>
              <div class="clearfix"></div>
              <br />
            </div>
          </form>

          <!-- form -->
        </section>
        <!-- content -->
      </div>
    </div>
  </div>

