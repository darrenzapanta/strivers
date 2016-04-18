
<div class="container">
    <?php echo $this->session->flashdata('message'); ?>
	<?php echo form_open('dssController/addDSS'); ?>
	<form class="col s12">
		<div class="row">
	        <div class="input-field col s12">
	        	<input name="full_name" id="full_name" type="text" class="validate">
	        	<label for="full_name">Full Name</label>
	        </div>
	    </div>
	    <div class="col m12">
	    <p class="right-align">
	    	<button class="btn btn-large waves-effect waves-light" type="submit" name="action">Add DSS</button>
	    </p>
	    </div>
	</form>
	<?php echo validation_errors(); ?>
</div>

