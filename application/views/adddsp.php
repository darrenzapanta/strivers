<div class="container">
    <?php echo $this->session->flashdata('message'); ?>
	<?php echo form_open('dspController/addDSP'); ?>
		<div class="row">
			<div class="input-field col s4">
				<input name="dealer_no" id="dealer_no" type="text" class="validate" value="<?php echo set_value('dealer_no'); ?>">
				<label for="dealer_no" >Dealer No.</label>
			</div>
		</div>
		<div class="row">
	        <div class="input-field col s12">
	        	<input name="full_name" id="full_name" type="text" class="validate" value="<?php echo set_value('full_name'); ?>">
	        	<label for="full_name">Full Name</label>
	        </div>
	    </div>
	    <div class="row">
	    	<div  class="input-field col s12">
	    		<select name="dss" id="dss" class="dsp">
						<?php foreach ($dss as $dss_item): ?>
	        				<option value="<?php echo $dss_item->dss_id; ?>"><?=$dss_item->dss_name?></option>
						<?php endforeach; ?>
	    		</select>

	    	<label>Assigned DSS</label>
	    	</div>
	    </div>
	    <div class="row">
	        <div class="input-field col s4">
		        <input name="percentage" id="percentage" type="number" min="0" max="100" class="validate" value="0" step="0.01" min="0">
		        <label for="percentage">Percentage</label>
	        </div>
	        <div class="input-field col s4">
	        	<select name="network" id="network">
	        		<option value="sun">SUN</option>
	        		<option value="smart" >SMART</option>
	        	</select>
	          <label>Network</label>
	        </div>
	        <div class="input-field col s4">
	          <input name="balance" id="balance" type="text" class="validate" value="0">
	          <label for="balance" >Balance</label>
	        </div>
	    </div>
	    <div class="col m12">
	    <p class="right-align">
	    	<button class="btn btn-large waves-effect waves-light" name="action" type="submit">Add DSP</button>
	    </p>
	    </div>
	</form>
	<?php echo validation_errors(); ?>

</div>
<script>
    $(document).ready(function() {
      $('select').material_select();
    });
</script>

