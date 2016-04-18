
<div class="container">
	<?php echo $this->session->flashdata('message'); ?>
	<?php echo form_open('transactionController/addTransaction'); ?>
		<div class="row">
	        <div class="input-field col s12">
	        	<select name="dsp" id="dsp" readonly>
	        		<option value="0"></option>
	        		<?php foreach ($dsp as $dsp_item): ?>
	        			<option value="<?php echo $dsp_item->dsp_id; ?>"><?=$dsp_item->dsp_name?></option>
	        		<?php endforeach; ?>	
	        	</select>
	        	<label for="dsp">Name</label>
	        </div>
	    </div>		
		<div class="row">
			<div class="input-field col s4">
				<select name="dealer_no"  id="dealer_no" name="dealer_no" readonly>
	        		<option value="0"></option>
	        		<?php foreach ($dsp as $dsp_item): ?>
	        			<option data-id="<?php echo $dsp_item->dsp_id; ?>" value="<?php echo $dsp_item->dealer_no; ?>"><?=$dsp_item->dealer_no?></option>
	        		<?php endforeach; ?>	
	        	</select>
				<label  for="dealer_no">Dealer No.</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s8">
				<label class="active">Date of Transaction</label>
				<input name="date_created" id="date_created" type="date" value="<?php echo date('Y-m-d'); ?>"></input>
			</div>
			<div class="input-field col s4">
				<input name="confirmation_no" id="confirmation_no" type="text" required></input>
				<label for="confirmation_no">Confirmation No.</label>
			</div>
		</div>

	    <div class="row">
	        <div class="input-field col s4">
		        <input name="amount" id="amount" type="text" class="validate" required>
		        <label for="amount">Amount</label>
	        </div>
	        <div class="input-field col s4">
	        	<select name="sim" id="sim">
	        		<?php foreach ($sim as $sim_item): ?>
	        			<option value="<?php echo $sim_item->global_name; ?>"><?=$sim_item->global_name?></option>
	        		<?php endforeach; ?>	
	        	</select>
	          <label>Global Sim</label>
	        </div>

	    </div>
	    <div class="row">
	        <div class="input-field col s4">
	          <input  id="begbalance" type="text" class="validate" readonly>
	          <label  for="balance">Beginning Balance</label>
	        </div>
	        <div class="input-field col s4">
	          <input  id="runbalance" type="text" class="validate" readonly>
	          <label  for="balance">Running Balance</label>
	        </div>
	    </div>	    
	    <div class="col m12">
	    <p class="right-align">
	    	<button class="btn btn-large waves-effect waves-light" type="submit" name="action">Add Transaction</button>
	    </p>
	    </div>
	</form>
	<?php echo validation_errors(); ?>

</div>

<script>
    var path = "<?php echo site_url(); ?>";
	var app = "transactionsController";


    $('#dsp').change(function(e){
    	$('#dealer_no option[data-id= "' + $('#dsp').val() + '"]').attr("selected","selected")
    	$('select').material_select();
    })

    $('#sim').change(function(e){
    	var global_name = $("#sim").val();
		$.ajax({
			method: 'POST',
	  		url: path + "/globalController/getBalance",
	  		cache: false,
	  		data: {global_name: global_name},
	  		async:false,
	  		success: function (data){
	  			if(data.status == "failed"){
	  				alert("Error has occurred.");
	  			}else{
	  				console.log(data.status);
	  				$("#begbalance").val(data.status);
	  				if(!isNaN($("#amount").val())){
	  					var running_balance = data.status - $("#amount").val();
	  					$('#runbalance').val(running_balance);
	  				}else{
	  					$('#runbalance').val(data.status);
	  				}
	  			}
	  		},
	  		error: function (data){
	  			alert(data);
	  		} 
		});    	
    });

    $('#amount').blur(function(e){
		if(!isNaN($("#amount").val())){
			var running_balance = $("#begbalance").val() - $("#amount").val();
			$('#runbalance').val(running_balance);
		}else{
			$('#runbalance').val(data.status);
		}    	
    })
    $(document).ready(function() {
      $('select').material_select();
      $('#sim').change();
    });
</script>