    <br>
    <br>
    <br>

    <div class="row">
        <center>
      <img height="200" width="250" src="<?php echo base_url(); ?>images/strivers.png">
        </center>
      </div>
  <div class="">

    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper" style="margin-top:0%">

      <div id="login" class="animate form">
      <?php if($this->session->flashdata('message') !== null): ?>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 alert alert-info">
            <h3><?php echo $this->session->flashdata('message'); ?></h3>
          </div>
        </div>
      <?php endif; ?>
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
          <h3 style="color:red"><?php echo validation_errors(); ?></h3>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
      <div id="register" class="animate form">
        <section class="login_content">
          <?php echo form_open('VerifyRegister'); ?>
            <h1>Create Account</h1>
            <div>
              <input name="username" type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input name="password" type="password" class="form-control" placeholder="Password" required="" />
            </div>

            <div>
              <input name="firstname" type="text" class="form-control" placeholder="First Name" required="" />
            </div>
            <div>
              <input name="lastname" type="text" class="form-control" placeholder="Last Name" required="" />
            </div>            
            <div>
              <button class="btn btn-default submit" type="submit"  >Register</button>
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
          <h3 style="color:red"><?php echo validation_errors(); ?></h3>
          <!-- form -->
        </section>
        <!-- content -->
      </div>

    </div>
  </div>

