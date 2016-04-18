
<div class="container">
	<table id="dsptable" class="responsive-table bordered centered highlight">
        <thead>
          <tr>

              <th data-field="dealer_no">Dealer No.</th>
              <th data-field="name">Name</th>
              <th data-field="dealer_no">DSS Name</th>
              <th data-field="network">Network</th>
              <th data-field="percentage">Percentage</th>
              <th data-field="balance">Balance</th>
          </tr>
        </thead>
        <!-- PHP append na lang based sa results sa DB, tsaka PHP din sa clickable table,  !-->
        <tbody class="dsp">
         <?php foreach ($dsp as $dsp_item): ?>
         	<tr class="modal-trigger" href="#modal1" data-id="<?php echo $dsp_item->dsp_id; ?>" id="<?php echo $dsp_item->dsp_id; ?>">
	          	<td class="dealer_no"><?php echo $dsp_item->dealer_no; ?></td>
	          	<td class="dsp_name"><?php echo $dsp_item->dsp_name; ?></td>
	          	<input type="hidden" value="<?php echo $dsp_item->dss_id; ?>" class="dss_id">
	          	<td class="dsp_name"><?php echo $dsp_item->dss_name; ?></td>
	          	<td class="network"><?php echo strtoupper($dsp_item->network); ?></td>
	          	<input type="hidden" value="<?php echo $dsp_item->percentage; ?>" class="percentage">
	          	<td><?php echo $dsp_item->percentage; ?>%</td>
	          	<td class="balance"><?php echo $dsp_item->balance; ?></td>
          	</tr>
         <?php endforeach; ?>	 

        </tbody>
         
      </table>          
  	<div id="modal1" class="modal">
  		<div class="modal-content">
      		<h4>Edit DSP details</h4>
      		<form class="col s12">
      			<div class="row">
      				<input id="modalid" type="hidden">
					<div class="input-field col s4">
						<input id="newdealer_no" type="text" class="validate">
						<label for="newdealer_no">Dealer No.</label>
					</div>
				</div>
				<div class="row">
			        <div class="input-field col s12">
			        	<input id="newfull_name" type="text" class="validate">
			        	<label for="newfull_name">Full Name</label>
			        </div>
			    </div>
			    <div class="row">
			    	<div class="input-field col s12">
			    		<select name="newdss" id="newdss" class="dsp">
								<?php foreach ($dss as $dss_item): ?>
			        				<option value="<?php echo $dss_item->dss_id; ?>"><?=$dss_item->dss_name?></option>
								<?php endforeach; ?>
			    		</select>
			    	<label>Assigned DSS</label>
			    	</div>
			    </div>
			    <div class="row">
			        <div class="input-field col s4">
			        	<select id="newnetwork">
			        		<option value="sun">SUN</option>
			        		<option value="smart">SMART</option>
			        	</select>
			          <label>Network</label>
			        </div>			    
			        <div class="input-field col s4">
				        <input id="newpercentage" type="number" min="0" max="100" class="validate">
				        <label for="newpercentage">Percentage</label>
			        </div>
			        <div class="input-field col s4">
			          <input id="newbalance" type="text" class="validate">
			          <label for="balance">Balance</label>
			        </div>
			    </div>
			    <div class="col m12">
			    <p class="right-align">
			    	<button id="edit" class="btn btn-large waves-effect waves-light" type="button" name="action">Edit Details</button>
			    	<button id="delete" class="btn btn-large waves-effect waves-red red" type="button" name="action">Delete DSP</button>
			    </p>
			    </div>
      		</form>
      	</div>
  	</div>
  </div>
<script>
 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    //$('.modal-trigger').openModal();
    //$('#modal1').openModal();
    $('select').material_select();
    $(document).on('click', '.modal-trigger', function(e) {
	    e.preventDefault();
	    //you have to trigger modal like this
	    //$(".modal-trigger").leanModal();
	    var dataid = $(this).data('id');
	    var dss_id = $("#"+ dataid + " .dss_id").val();
	    var network = $("#"+ dataid + " .network").html();
	    $('#modalid').val(dataid);
	    $('#newdealer_no').val($("#"+ dataid + " .dealer_no").html());
	    $('#newfull_name').val($("#"+ dataid + " .dsp_name").html());
	    $('#newdss option[value= "' + dss_id + '"]').attr("selected","selected");
	    $('#newnetwork option[value= "' + network + '"]').attr("selected","selected");
	    $('#newpercentage').val($("#"+ dataid + " .percentage").val());
	    $('#newbalance').val($("#"+ dataid + " .balance").html());
	    $('#modal1').openModal();
	    $('select').material_select();
	    Materialize.updateTextFields()
	  });



  });

    var path = "<?php echo site_url(); ?>";
	var app = "dspController";
	$("#edit").click(function(e){
		var name = $("#newfull_name").val();
		var network = $("#newnetwork").val();
		var dealerNo = $("#newdealer_no").val();
		var percentage = $("#newpercentage").val();
		var balance = $("#newbalance").val();
		var dsp_id = $("#modalid").val();
		var dss = $("#newdss").val();
		if(dss == 0)
			dss = null;
		$.ajax({
			method: 'POST',
	  		url: path + "/" + app + "/editDSP",
	  		cache: false,
	  		data: {dsp_id: dsp_id, full_name: name, network: network, dealer_no: dealerNo, percentage: percentage, balance: balance, dss:dss},
	  		async:false,
	  		success: function (data){
	  			if(data.status == "success"){
	  				location.reload();
	  			}else{
	  				alert("Error has occurred.");
	  			}

	  		},
	  		error: function (data){
	  			alert(data);
	  		} 
		});
	});
	$("#delete").click(function(e){
		var target = $("#modalid").val();
		$.ajax({
			method: 'POST',
	  		url: path + "/" + app + "/deleteDSP",
	  		cache: false,
	  		data: {dsp_id: target},
	  		async:false,
	  		success: function (data){
	  			if(data.status == "success"){
	  				alert("Deleted.");
	  				location.reload();
	  				$('#modal1').closeModal();
	  			}else{
	  				alert("Error has occurred.");
	  			}
	  		},
	  		error: function (data){
	  			alert("Error has occurred.");
	  		} 
		});
	});
</script>

