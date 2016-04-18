

<br>
<div class="container">
   
   <?php echo form_open('VerifyLogin'); ?>
		<div class="row">
	        <div class="input-field col s12">
	          <input name="username" id="username" type="text" class="validate">
	          <label for="user_name">User Name</label>
	        </div>
	    </div>
	    <div class="row">
	        <div class="input-field col s12">
	          <input name="password" id="password" type="password" class="validate">
	          <label for="password">Password</label>
	        </div>
	    </div>
	    <div class="col m12">
	    <p class="right-align">
	    	<button class="btn btn-large waves-effect waves-light" type="submit" name="action">Login</button>
	    </p>
	    </div>
	</form>
	<?php echo validation_errors(); ?>
</div>




